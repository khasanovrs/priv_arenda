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

    /**
     * Функция добавления скидки
     * @param $discount
     * @return array|bool
     */
    public static function AddDiscount($discount)
    {
        Yii::info('Запуск функции AddDiscount', __METHOD__);

        $newDiscount = new Discount();

        $newDiscount->code = (int)$discount;
        $newDiscount->name = $discount;

        try {
            if (!$newDiscount->save(false)) {
                Yii::error('Ошибка при добавлении новой скидки: ' . serialize($newDiscount->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при добавлении новой скидки: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        return [
            'status' => 'SUCCESS',
            'msg' => 'Скидка успешно добавлена'
        ];
    }

    /**
     * Функция удаления филиала
     * @param $discount
     * @return array|bool
     */
    public static function DeleteDiscount($discount) {
        Yii::info('Запуск функции AddBranch', __METHOD__);

        try {
            Discount::deleteAll('id=:id', [':id' => $discount]);
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при удалении скидки: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        return [
            'status' => 'SUCCESS',
            'msg' => 'Скидка успешно удалена'
        ];
    }
}