<?php
/**
 * Управление платежами
 */

namespace app\components\pay;

use app\components\Session\Sessions;
use app\models\ApplicationEquipment;
use app\models\ApplicationPay;
use Yii;

class PayClass
{
    /**
     * @param $sum
     * @param $application_equipment_id
     * @param $cashBox
     * @param $revertSum
     * @return array | bool
     * @throws \yii\base\InvalidConfigException
     */
    public static function AddPay($application_equipment_id, $sum, $cashBox, $revertSum)
    {
        Yii::info('Запуск функции AddPay', __METHOD__);

        if ($sum === '') {
            Yii::info('Не указана сумма', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не указана сумма'
            ];
        }

        if ($application_equipment_id === '') {
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

        $newPay = new ApplicationPay();

        $newPay->user_id = $session->user_id;
        $newPay->sum = $revertSum ? '-' . $sum : '';
        $newPay->cashBox = $cashBox;
        $newPay->application_equipment_id = $application_equipment_id;
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

        /**
         * @var ApplicationEquipment $app_eq
         */
        $app_eq = ApplicationEquipment::find()->where('id=:id', [':id' => $application_equipment_id])->one();

        if (!is_object($app_eq)) {
            Yii::error('Заявка на оборудование не найдено: ' . serialize($app_eq), __METHOD__);
            return false;
        }

        if($revertSum) {
            $app_eq->total_paid = (float)$app_eq->total_paid - (float)$sum;
        } else {
            $app_eq->total_paid = (float)$app_eq->total_paid + (float)$sum;
        }


        try {
            if (!$app_eq->save(false)) {
                Yii::error('Ошибка при сохранении общей суммы платежа: ' . serialize($app_eq->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при сохранении общей суммы платежа: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        return [
            'status' => 'SUCCESS',
            'msg' => 'Платеж успешно добавлен'
        ];
    }

    public static function getPayList($application_equipment_id)
    {
        Yii::info('Запуск функции getPayList', __METHOD__);

        if ($application_equipment_id === '') {
            Yii::error('Не указана идентификатор заявки', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не указана идентификатор заявки'
            ];
        }

        $pay_list = [];

        $pay_list_arr = ApplicationPay::find()->where('application_equipment_id=:id', ['id' => $application_equipment_id])->orderBy('id desc')->all();

        if (empty($pay_list_arr)) {
            Yii::info('Платежей нет', __METHOD__);
        } else {
            /**
             * @var ApplicationPay $value
             */
            foreach ($pay_list_arr as $value) {
                $arr = [
                    'date' => date('d.m.Y H:i', strtotime($value->date_create)),
                    'user_id' => $value->user->fio,
                    'sum' => $value->sum
                ];

                array_push($pay_list, $arr);
            }
        }

        Yii::info('Платежи успешно получены', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Платежи успешно получены',
            'data' => $pay_list
        ];
    }


}