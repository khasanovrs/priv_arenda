<?php
/**
 * Удаление кассы
 */

namespace app\components\actions\cashBox;

use app\components\CashBox\CashBoxClass;
use Yii;
use yii\base\Action;

class DeleteCashBoxAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции удаления кассы', __METHOD__);

        $request = Yii::$app->request;

        $id = $request->getBodyParam('id');

        $resultChange = CashBoxClass::DeleteCashBox($id);

        if (!is_array($resultChange) || !isset($resultChange['status']) || $resultChange['status'] != 'SUCCESS') {
            Yii::error('Ошибка при удалении кассы', __METHOD__);

            if (is_array($resultChange) && isset($resultChange['status']) && $resultChange['status'] === 'ERROR') {
                return $resultChange;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при удалении кассы',
            ];
        }

        Yii::info('Касса успешно удалена', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Касса успешно удалена',
        ];
    }
}