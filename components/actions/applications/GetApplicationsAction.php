<?php
/**
 * Получение списка заявок
 */

namespace app\components\actions\applications;

use app\components\applications\ApplicationsClass;
use Yii;
use yii\base\Action;

class GetApplicationsAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции получения списка заявок', __METHOD__);

        $request = Yii::$app->request;

        $status = $request->getBodyParam('status');
        $source = $request->getBodyParam('source');
        $branch = $request->getBodyParam('branch');
        $date_start = $request->getBodyParam('date_start');
        $date_end = $request->getBodyParam('date_end');

        $result = ApplicationsClass::getApplications($status, $source, $branch, $date_start, $date_end);

        if (!is_array($result) || !isset($result['status']) || $result['status'] != 'SUCCESS') {
            Yii::error('Ошибка при получении списка заявок', __METHOD__);

            if (is_array($result) && isset($result['status']) && $result['status'] === 'ERROR') {
                return $result;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при получении списка заявок',
            ];
        }

        Yii::info('Заявки успешно получены', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Заявки успешно получены',
            'data' => $result['data']
        ];
    }
}