<?php
/**
 * Управление парметрами
 */

namespace app\components\discount;

use app\models\Discount;
use Yii;

class DiscountClass
{
    /**
     * Получение списка скидок
     * @return bool|array
     */
    public static function GetDiscount()
    {
        Yii::info('Запуск функции GetDiscount', __METHOD__);
        $result = [];

        $discountList = Discount::find()->orderBy('code')->all();

        if (!is_array($discountList)) {
            Yii::error('Список скидок пуст', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Список ролей пуст'
            ];
        }

        /**
         * @var Discount $value
         */
        foreach ($discountList as $value) {
            $result[] = [
                'val' => $value->id,
                'name' => $value->name
            ];
        }

        Yii::info('Список скидок успешно получен', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Список скидок успешно получен',
            'data' => $result
        ];
    }
}