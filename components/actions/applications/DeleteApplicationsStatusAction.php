<?php
/**
 * Удаление статуса заявки
 */

namespace app\components\actions\applications;

use app\components\applications\ApplicationsClass;
use Yii;
use yii\base\Action;

class DeleteApplicationsStatusAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции удаления статуса заявки', __METHOD__);

        $request = Yii::$app->request;

        $id = $request->getBodyParam('id');

        $resultChange = ApplicationsClass::DeleteStatus($id);

        if (!is_array($resultChange) || !isset($resultChange['status']) || $resultChange['status'] != 'SUCCESS') {
            Yii::error('Ошибка при удалении статуса для заявки', __METHOD__);

            if (is_array($resultChange) && isset($resultChange['status']) && $resultChange['status'] === 'ERROR') {
                return $resultChange;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при удалении статуса для заявки',
            ];
        }

        Yii::info('Статус для заявки успешно удалена', __METHOD__);

        return [
            'status' => 'ОК',
            'msg' => 'Статус успешно удален',
        ];
    }
}