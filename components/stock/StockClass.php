<?php
/**
 * Управление складами
 */

namespace app\components\Stock;

use app\models\Branch;
use app\models\Equipments;
use app\models\Stock;
use Yii;

class StockClass
{
    /**
     * Получение списка складов
     * @return bool|array
     */
    public static function GetStock()
    {
        Yii::info('Запуск функции удаления склада', __METHOD__);

        $result = [];

        $stocks = Stock::find()->all();

        if (empty($stocks)) {
            Yii::info('Список складов пуст', __METHOD__);

            return [
                'status' => 'SUCCESS',
                'msg' => 'Список складов пуст',
                'data' => $result
            ];
        }

        /**
         * @var Stock $value
         */
        foreach ($stocks as $value) {
            $result[] = [
                'val' => $value->id,
                'name' => $value->name,
                'branch_id' => $value->id_branch,
            ];
        }

        Yii::info('Склады успешно получены', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Склады успешно получены',
            'data' => $result
        ];
    }

    /**
     * Добавление нового склада
     * @param $id_branch
     * @param $name
     * @param $val
     * @return bool|array
     */
    public static function AddStock($id_branch, $name, $val)
    {
        Yii::info('Запуск функции добавления нового склада', __METHOD__);

        if ($name === '') {
            Yii::error('Ни передано наименование склада, name:' . serialize($name), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ни передано наименование статуса',
            ];
        }

        if ($id_branch == '' && $val === '') {
            Yii::error('Ни передан идентификатор филиала, id_branch:' . serialize($id_branch), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ни передан идентификатор филиала',
            ];
        }

        $branch = Branch::find()->where('id=:id', [':id' => $id_branch])->one();

        if (!is_object($branch) && $val === '') {
            Yii::error('Указанный филиал ни найден, id_branch:' . serialize($id_branch), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Указанный филиал ни найден',
            ];
        }

        if ($val !== '') {
            $new_stock = Stock::find()->where('id=:id', [':id' => $val])->one();

            if (!is_object($new_stock)) {
                Yii::error('Передан некорректный идентификатор, id:' . serialize($val), __METHOD__);

                return [
                    'status' => 'ERROR',
                    'msg' => 'Передан некорректный идентификатор',
                ];
            }
        } else {
            $new_stock = new Stock();
            $new_stock->id_branch = $id_branch;
            $new_stock->date_create = date('Y-m-d H:i:s');
        }

        $new_stock->name = $name;
        $new_stock->date_update = date('Y-m-d H:i:s');

        try {
            if (!$new_stock->save(false)) {
                Yii::error('Ошибка при добавлении нового склада: ' . serialize($new_stock->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при добавлении нового склада: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        Yii::info('Склад успешно добавлен', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => $val === '' ? 'Склад успешно добавлен' : 'Склад для клиента успешно обновлен'
        ];
    }

    /**
     * Удаление статуса юр. лиц
     * @param $id ,
     * @return bool|array
     */
    public static function DeleteStock($id)
    {
        Yii::info('Запуск функции удаления склада', __METHOD__);

        if ($id === '') {
            Yii::error('Ни передано идентификатор склада, id:' . serialize($id), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ни передан идентификатор склада',
            ];
        }

        $check_status = Equipments::find()->where('stock_id=:status', [':status' => $id])->one();
        if (is_object($check_status)) {
            Yii::error('Данный статус нельзя удалить. Статус используется для оборудований, id:' . serialize($id), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Данный статус нельзя удалить. Статус используется для оборудований',
            ];
        }

        $check_status = Equipments::find()->where('stock_id=:status', [':status' => $id])->one();
        if (is_object($check_status)) {
            Yii::error('Данный статус нельзя удалить. Статус используется для оборудований, id:' . serialize($id), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Данный статус нельзя удалить. Статус используется для оборудований',
            ];
        }

        try {
            Stock::deleteAll('id=:id', array(':id' => $id));
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при удалении склада: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        Yii::info('Склад успешно удален', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Склад успешно удален'
        ];
    }
}