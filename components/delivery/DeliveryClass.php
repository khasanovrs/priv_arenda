<?php
/**
 * Управление доставкой
 */

namespace app\components\discount;

use app\models\ApplicationSumDelivery;
use Yii;

class DeliveryClass
{
    /**
     * Добавление доставки
     * @param $sum
     * @param $sum_paid
     * @return array|bool
     */
    public static function AddDelivery($sum, $sum_paid)
    {
        Yii::info('Запуск функции addDelivery', __METHOD__);


        $newDelivery = new ApplicationSumDelivery();
        $newDelivery->delivery_sum = $sum;
        $newDelivery->delivery_sum_paid = $sum_paid;

        try {
            if (!$newDelivery->save(false)) {
                Yii::error('Ошибка при добавлении доставки: ' . serialize($newDelivery->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при добавлении доставки: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        Yii::info('Доставка успешно добавлена', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Доставка успешно добавлена',
            'data' => $newDelivery->id
        ];
    }
}