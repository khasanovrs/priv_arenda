<?php
/**
 * Добавление скидок
 */

namespace app\components\actions\discount;

use app\components\discount\DiscountClass;
use Yii;
use yii\base\Action;

class AddDiscountAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции добавления скидки', __METHOD__);

        $request = Yii::$app->request;

        $discount = $request->getBodyParam('discount');

        $resultChange = DiscountClass::AddDiscount($discount);

        if (!is_array($resultChange) || !isset($resultChange['status']) || $resultChange['status'] != 'SUCCESS') {
            Yii::error('Ошибка при добавлении новой скидки', __METHOD__);

            if (is_array($resultChange) && isset($resultChange['status']) && $resultChange['status'] === 'SUCCESS') {
                return $resultChange;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при добавлении новой скидки',
            ];
        }

        Yii::info('Скидка успешно добавлена', __METHOD__);

        return [
            'status' => 'ОК',
            'msg' => 'Скидка успешно добавлена',
        ];
    }
}