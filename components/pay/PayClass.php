<?php
/**
 * Управление платежами
 */

namespace app\components\pay;

use app\components\Session\Sessions;
use app\models\ApplicationPay;
use Yii;

class PayClass
{
    /**
     * @param $sum
     * @param $application_equipment_id
     * @return array | bool
     * @throws \yii\base\InvalidConfigException
     */
    public static function AddPay($application_equipment_id, $sum)
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
        $newPay->sum = $sum;
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

        return [
            'status' => 'SUCCESS',
            'msg' => 'Платеж успешно добавлен'
        ];
    }
}