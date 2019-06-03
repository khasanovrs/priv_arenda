<?php
/**
 * Управление складами
 */

namespace app\components\Stock;

use app\models\Branch;
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
}