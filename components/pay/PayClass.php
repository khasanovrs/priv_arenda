<?php
/**
 * Управление платежами
 */

namespace app\components\pay;

use app\components\Clients\ClientsClass;
use app\components\Session\Sessions;
use app\models\ApplicationEquipment;
use app\models\ApplicationPay;
use app\models\Applications;
use app\models\Extension;
use app\models\FinanceCashbox;
use Yii;

class PayClass
{
    /**
     * @param $sum
     * @param $application_id
     * @param $cashBox
     * @param $revertSum
     * @return array | bool
     * @throws \yii\base\InvalidConfigException
     */
    public static function AddPay($application_id, $sum, $cashBox, $revertSum)
    {
        Yii::info('Запуск функции AddPay', __METHOD__);

        if ($sum === '') {
            Yii::info('Не указана сумма', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не указана сумма'
            ];
        }

        if ($application_id === '') {
            Yii::info('Не указана идентификатор заявки', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не указана идентификатор заявки'
            ];
        }

        if ($cashBox === '') {
            Yii::info('Не указана идентификатор кассы', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не указана идентификатор кассы'
            ];
        }

        /**
         * @var Sessions $Sessions
         */
        $Sessions = Yii::$app->get('Sessions');
        $session = $Sessions->getSession();

        if (!is_object($session)) {
            Yii::error('Ошибка при опредении пользователя', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при опредении пользователя'
            ];
        }

        /**
         * @var Applications $app
         */
        $app = Applications::find()->where('id=:id', [':id' => $application_id])->one();

        if (!is_object($app)) {
            Yii::error('Заявка на оборудование не найдено: ' . serialize($app), __METHOD__);
            return false;
        }

        $eq = $app->applicationEquipments[0]->equipments;

        if (!is_object($eq)) {
            Yii::error('Оборудование не найдено', __METHOD__);
            return false;
        }

        if ((int)$eq->selling_price === 0) {
            Yii::info('Необходимо указать сумму продажи оборудования', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Необходимо указать сумму продажи оборудования'
            ];
        }

        $newPay = new ApplicationPay();
        $newPay->user_id = $session->user_id;
        $newPay->sum = ($revertSum ? '-' : '') . $sum;
        $newPay->cashBox = $cashBox;
        $newPay->application_id = $app->id;
        $newPay->client_id = $app->client_id;
        $newPay->date_create = date('Y-m-d H:i:s');

        try {
            if (!$newPay->save(false)) {
                Yii::error('Ошибка при добавлении платежа: ' . serialize($newPay->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при добавлении нового платежа: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        Yii::info('Обновляем общую сумму', __METHOD__);

        if ($newPay->cashBox0->check_zalog === '0' && $newPay->cashBox0->delivery === '0') {
            Yii::info('Работаем полем "Оплачено всего"', __METHOD__);
            if ($revertSum) {
                $app->total_paid = (float)$app->total_paid - (float)$sum;
            } else {
                $app->total_paid = (float)$app->total_paid + (float)$sum;
            }

            Yii::info('Работа с полем "выручка"', __METHOD__);

            if ($revertSum) {
                $eq->revenue = (float)$eq->revenue - (float)$sum;
            } else {
                $eq->revenue = (float)$eq->revenue + (float)$sum;
            }

            $eq->profit = (float)$eq->revenue - (float)$eq->repairs_sum;
            $eq->payback_ratio = round($eq->profit == 0 ? 0 : (float)$eq->profit / (float)$eq->selling_price, 2);

            try {
                if (!$eq->save(false)) {
                    Yii::error('Ошибка при сохранении информации по оборудованию: ' . serialize($eq->getErrors()), __METHOD__);
                    return false;
                }
            } catch (\Exception $e) {
                Yii::error('Поймали Exception при сохранении информации по оборудованию: ' . serialize($e->getMessage()), __METHOD__);
                return false;
            }

            $clientId = $app->client_id;

            $checkChangeBonusAccount = ClientsClass::changeBonusAccountClient($clientId, $sum, $revertSum);

            if (!is_array($checkChangeBonusAccount) || !isset($checkChangeBonusAccount['status']) || $checkChangeBonusAccount['status'] != 'SUCCESS') {
                Yii::error('Ошибка при изменении бонусного счета клиента', __METHOD__);

                return [
                    'status' => 'ERROR',
                    'msg' => 'Ошибка при изменении бонусного счета клиента',
                ];
            }
        } elseif ($newPay->cashBox0->delivery === '1') {
            $delivery = $app->deliverySum;

            if (!is_object($delivery)) {
                Yii::error('Доставка не найдена: ' . serialize($app), __METHOD__);
                return false;
            }

            $delivery->delivery_sum_paid += (float)$sum;

            try {
                if (!$delivery->save(false)) {
                    Yii::error('Ошибка при сохранении информации по доставке: ' . serialize($delivery->getErrors()), __METHOD__);
                    return false;
                }
            } catch (\Exception $e) {
                Yii::error('Поймали Exception при сохранении информации по доставке: ' . serialize($e->getMessage()), __METHOD__);
                return false;
            }

        }

        try {
            if (!$app->save(false)) {
                Yii::error('Ошибка при сохранении общей суммы платежа: ' . serialize($app->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при сохранении общей суммы платежа: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        $check_update = self::updateCashBox($cashBox, $sum, $revertSum);

        if (!is_array($check_update) || !isset($check_update['status']) || $check_update['status'] != 'SUCCESS') {
            Yii::error('Ошибка при обновлении кассы', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при обновлении кассы',
            ];
        }

        return [
            'status' => 'SUCCESS',
            'msg' => 'Платеж успешно добавлен'
        ];
    }

    /**
     * Получение списка платежей
     * @param $app_id
     * @return array
     */
    public static function getPayList($app_id)
    {
        Yii::info('Запуск функции getPayList', __METHOD__);

        $pay_list = [];

        $pay_list_arr = ApplicationPay::find()->where('application_id=:application_id', [':application_id' => $app_id])->orderBy('id desc')->all();

        if (empty($pay_list_arr)) {
            Yii::info('Платежей нет', __METHOD__);
        } else {
            /**
             * @var ApplicationPay $value
             */
            foreach ($pay_list_arr as $value) {
                $pay_list[] = [
                    'date' => date('d.m.Y H:i', strtotime($value->date_create)),
                    'user_id' => $value->user->fio,
                    'sum' => $value->sum,
                    'cash_box' => $value->cashBox0->name
                ];

            }
        }

        Yii::info('Платежи успешно получены', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Платежи успешно получены',
            'data' => $pay_list
        ];
    }

    /**
     * Получение списка продлений
     * @param $app_id
     * @return array
     */
    public static function getExtensions($app_id)
    {
        Yii::info('Запуск функции getExtensions', __METHOD__);

        if ($app_id === '') {
            Yii::error('Не указана идентификатор заявки', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не указана идентификатор заявки'
            ];
        }

        $extension_list = [];

        $extensions_arr = Extension::find()->where('application_id=:id', ['id' => $app_id])->orderBy('id desc')->all();

        if (empty($extensions_arr)) {
            Yii::info('Платежей нет', __METHOD__);
        } else {
            /**
             * @var Extension $value
             */
            foreach ($extensions_arr as $value) {

                $txt = $value->extend === '1' ? 'Продление ' : 'Сокращение ';
                $txt .= ($value->type == 1) ? 'дней: ' : 'месяцев: ';

                $arr = [
                    'date' => date('d.m.Y H:i', strtotime($value->date_create)),
                    'user_id' => $value->user->fio,
                    'count' => $txt . $value->count
                ];

                array_push($extension_list, $arr);
            }
        }

        Yii::info('Продления успешно получены', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Продленич успешно получены',
            'data' => $extension_list
        ];
    }

    /**
     * Добавление платежа в кассу
     * @param $id
     * @param $sum
     * @param $revert
     * @return array|bool
     */
    public static function updateCashBox($id, $sum, $revert)
    {
        Yii::info('Запуск обновления суммы кассы', __METHOD__);

        /**
         * @var FinanceCashbox $cash_box
         */
        $cash_box = FinanceCashbox::find()->where('id=:id', [':id' => $id])->one();

        if (!is_object($cash_box)) {
            Yii::error('Ошибка при опредении кассы', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при опредении кассы'
            ];
        }

        if ($revert) {
            $cash_box->sum -= (float)$sum;
        } else {
            $cash_box->sum += (float)$sum;
        }

        try {
            if (!$cash_box->save(false)) {
                Yii::error('Ошибка при изменении суммы кассы: ' . serialize($cash_box->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при изменении суммы кассы: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        Yii::info('Сумма кассы успешно изменена', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Сумма кассы успешно изменена'
        ];
    }
}