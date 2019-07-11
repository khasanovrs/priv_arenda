<?php
/**
 * Удаление склада
 */

namespace app\components\actions\stock;

use app\components\stock\StockClass;
use Yii;
use yii\base\Action;

class DeleteStockAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции удаления склада', __METHOD__);

        $request = Yii::$app->request;

        $id = $request->getBodyParam('id');

        $resultChange = StockClass::DeleteStock($id);

        if (!is_array($resultChange) || !isset($resultChange['status']) || $resultChange['status'] != 'SUCCESS') {
            Yii::error('Ошибка при удалении склада', __METHOD__);

            if (is_array($resultChange) && isset($resultChange['status']) && $resultChange['status'] === 'ERROR') {
                return $resultChange;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при удалении склада',
            ];
        }

        Yii::info('Склад успешно удален', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Склад успешно удален',
        ];
    }
}