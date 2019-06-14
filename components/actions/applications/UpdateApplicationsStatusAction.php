<?php
/**
 * Изменение статусов зявки
 */

namespace app\components\actions\applications;

use app\components\applications\ApplicationsClass;
use Yii;
use yii\base\Action;

class UpdateApplicationsStatusAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции изменения статуса заявки', __METHOD__);

        $request = Yii::$app->request;

        $application_id = $request->getBodyParam('application_id');
        $application_status = $request->getBodyParam('application_status');

        $result = ApplicationsClass::UpdateApplicationsStatus($application_id, $application_status);

        if (!is_array($result) || !isset($result['status']) || $result['status'] != 'SUCCESS') {
            Yii::error('Ошибка при изменении статуса заявки', __METHOD__);

            if (is_array($result) && isset($result['status']) && $result['status'] === 'ERROR') {
                return $result;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при изменении статуса заявки',
            ];
        }

        Yii::info('Статус заявки успешно изменен', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Статус заявки успешно изменен'
        ];
    }
}