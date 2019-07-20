<?php
/**
 * Удаление категории
 */

namespace app\components\actions\finance;

use app\components\finance\FinanceClass;
use Yii;
use yii\base\Action;

class DeleteFinanceCategoryAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции удаления категории', __METHOD__);

        $request = Yii::$app->request;

        $id = $request->getBodyParam('id');

        $resultChange = FinanceClass::DeleteCategory($id);

        if (!is_array($resultChange) || !isset($resultChange['status']) || $resultChange['status'] != 'SUCCESS') {
            Yii::error('Ошибка при удалении категории', __METHOD__);

            if (is_array($resultChange) && isset($resultChange['status']) && $resultChange['status'] === 'ERROR') {
                return $resultChange;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при удалении категории',
            ];
        }

        Yii::info('Категория успешно удалена', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Категория успешно удалена',
        ];
    }
}