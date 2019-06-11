<?php
/**
 * Получение статусов зявки
 */

namespace app\components\actions\equipments;

use app\components\equipments\ApplicationsClass;
use Yii;
use yii\base\Action;

class GetApplicationsStatusAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции получения статусов заявки', __METHOD__);

        $result = ApplicationsClass::GetApplicationsStatus();

        if (!is_array($result) || !isset($result['status']) || $result['status'] != 'SUCCESS') {
            Yii::error('Ошибка при получении списка статусов заявок', __METHOD__);

            if (is_array($result) && isset($result['status']) && $result['status'] === 'ERROR') {
                return $result;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при получении списка статусов заявок',
            ];
        }

        Yii::info('Список статусов заявок успешно получен', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Список статусов заявок успешно получен',
            'data' => $result['data']
        ];
    }
}