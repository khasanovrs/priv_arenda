<?php
/**
 * Добавление нового скалада
 */

namespace app\components\actions\stock;

use app\components\stock\StockClass;
use Yii;
use yii\base\Action;

class AddStockAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции добавления нового склада', __METHOD__);

        $request = Yii::$app->request;

        $name = $request->getBodyParam('name');
        $id_branch = $request->getBodyParam('branch');
        $val = $request->getBodyParam('val');

        $resultChange = StockClass::AddStock($id_branch, $name, $val);

        if (!is_array($resultChange) || !isset($resultChange['status']) || $resultChange['status'] != 'SUCCESS') {
            Yii::error('Ошибка при добавлении нового склада', __METHOD__);

            if (is_array($resultChange) && isset($resultChange['status']) && $resultChange['status'] === 'ERROR') {
                return $resultChange;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при добавлении нового склада',
            ];
        }

        Yii::info('Склад успешно добавлен', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => $resultChange['msg'],
        ];
    }
}