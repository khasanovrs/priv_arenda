<?php
/**
 * Изменение списка полей для зявок
 */

namespace app\components\actions\equipments;

use app\components\equipments\ApplicationsClass;
use Yii;
use yii\base\Action;

class ChangeApplicationsFieldAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции изменения списка полей для заявок', __METHOD__);

        $request = Yii::$app->request;

        $params = $request->getBodyParam('data');

        $result = ApplicationsClass::ChangeApplicationsFields($params);

        if (!is_array($result) || !isset($result['status']) || $result['status'] != 'SUCCESS') {
            Yii::error('Ошибка при изменении списка полей для заявок', __METHOD__);

            if (is_array($result) && isset($result['status']) && $result['status'] === 'ERROR') {
                return $result;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при изменении списка полей для заявок',
            ];
        }

        Yii::info('Списки полей для заявок успешно изменены', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Списки полей для заявок успешно изменены',
            'data' => $result['data']
        ];
    }
}