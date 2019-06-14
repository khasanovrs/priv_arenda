<?php
/**
 * Получение детальной информации по заявке
 */

namespace app\components\actions\applications;

use app\components\applications\ApplicationsClass;
use Yii;
use yii\base\Action;

class GetApplicationInfoAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции получения детальной информации по заявке', __METHOD__);

        $request = Yii::$app->request;

        $applicationId = $request->getBodyParam('applicationId');

        $result = ApplicationsClass::getApplicationInfo($applicationId);

        if (!is_array($result) || !isset($result['status']) || $result['status'] != 'SUCCESS') {
            Yii::error('Ошибка при получении информации о заявке', __METHOD__);

            if (is_array($result) && isset($result['status']) && $result['status'] === 'ERROR') {
                return $result;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при получении информации о заявке',
            ];
        }

        Yii::info('Заявка успешно получена', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Заявка успешно получена',
            'data' => $result['data']
        ];
    }
}