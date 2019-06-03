<?php
/**
 * Получение скидок
 */

namespace app\components\actions\discount;

use Yii;
use yii\base\Action;

class GetDiscountAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции получения списка скидок', __METHOD__);

        $resultChange = DiscountClass::GetDiscount();

        if (!is_array($resultChange) || !isset($resultChange['status']) || $resultChange['status'] != 'SUCCESS') {
            Yii::error('Ошибка при получении списка скидок', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при получении списка скидок',
            ];
        }

        Yii::info('Список скидок успешно получен', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Список скидок успешно получен',
            'data' => $resultChange['data']
        ];
    }
}