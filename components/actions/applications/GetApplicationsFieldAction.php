<?php
/**
 * Получение списка полей для зявок
 */

namespace app\components\actions\applications;

use app\components\applications\ApplicationsClass;
use Yii;
use yii\base\Action;

class GetApplicationsFieldAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции получения списка полей для заявок', __METHOD__);

        $result = ApplicationsClass::GetApplicationsFields();

        if (!is_array($result) || !isset($result['status']) || $result['status'] != 'SUCCESS') {
            Yii::error('Ошибка при получении списка полей для заявок', __METHOD__);

            if (is_array($result) && isset($result['status']) && $result['status'] === 'ERROR') {
                return $result;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при получении списка полей для заявок',
            ];
        }

        Yii::info('Список полей для заявок успешно получен', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Список полей для заявок успешно получен',
            'data' => $result['data']
        ];
    }
}