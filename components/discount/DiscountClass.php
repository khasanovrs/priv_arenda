<?php
/**
 * Управление парметрами
 */

namespace app\components\discount;

use app\models\Applications;
use app\models\ClientsInfo;
use app\models\Discount;
use app\models\Equipments;
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
        $newDiscount->name = $discount . '%';

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
     * @param $id
     * @return array|bool
     */
    public static function DeleteDiscount($id)
    {
        Yii::info('Запуск функции AddBranch', __METHOD__);

        $check_status = Applications::find()->where('discount_id=:status', [':status' => $id])->one();
        if (is_object($check_status)) {
            Yii::error('Данный статус нельзя удалить. Статус используется в заявках, id:' . serialize($id), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Данный статус нельзя удалить. Статус используется в заявках',
            ];
        }

        $check_status = ClientsInfo::find()->where('sale=:status', [':status' => $id])->one();
        if (is_object($check_status)) {
            Yii::error('Данный статус нельзя удалить. Статус используется для клиентов, id:' . serialize($id), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Данный статус нельзя удалить. Статус используется для клиентов',
            ];
        }

        $check_status = Equipments::find()->where('discount=:status', [':status' => $id])->one();
        if (is_object($check_status)) {
            Yii::error('Данный статус нельзя удалить. Статус используется для оборудования, id:' . serialize($id), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Данный статус нельзя удалить. Статус используется для оборудования',
            ];
        }

        $check_status = Equipments::find()->where('discount=:status', [':status' => $id])->one();
        if (is_object($check_status)) {
            Yii::error('Данный статус нельзя удалить. Статус используется для оборудования, id:' . serialize($id), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Данный статус нельзя удалить. Статус используется для оборудования',
            ];
        }

        try {
            Discount::deleteAll('id=:id', [':id' => $id]);
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