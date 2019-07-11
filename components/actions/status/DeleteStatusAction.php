<?php
/**
 * Удаление статуса для клиента
 */

namespace app\components\actions\status;

use app\components\status\StatusClass;
use Yii;
use yii\base\Action;

class DeleteStatusAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции удаления статуса для клиента', __METHOD__);

        $request = Yii::$app->request;

        $id = $request->getBodyParam('id');

        $resultChange = StatusClass::DeleteStatus($id);

        if (!is_array($resultChange) || !isset($resultChange['status']) || $resultChange['status'] != 'SUCCESS') {
            Yii::error('Ошибка при удалении статуса для клиента', __METHOD__);

            if (is_array($resultChange) && isset($resultChange['status']) && $resultChange['status'] === 'ERROR') {
                return $resultChange;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при удалении статуса для клиента',
            ];
        }

        Yii::info('Статус успешно удален', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Статус успешно удален',
        ];
    }
}