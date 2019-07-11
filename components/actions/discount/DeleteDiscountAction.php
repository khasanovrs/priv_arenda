<?php
/**
 * Удаление скидки
 */

namespace app\components\actions\discount;

use app\components\discount\DiscountClass;
use Yii;
use yii\base\Action;

class DeleteDiscountAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции удаления скидки', __METHOD__);

        $request = Yii::$app->request;

        $discount = $request->getBodyParam('id');

        $resultChange = DiscountClass::DeleteDiscount($discount);

        if (!is_array($resultChange) || !isset($resultChange['status']) || $resultChange['status'] != 'SUCCESS') {
            Yii::error('Ошибка при удалении скидки', __METHOD__);

            if (is_array($resultChange) && isset($resultChange['status']) && $resultChange['status'] === 'ERROR') {
                return $resultChange;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при удалении скидки',
            ];
        }

        Yii::info('Скидка успешно удалена', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Скидка успешно удалена',
        ];
    }
}