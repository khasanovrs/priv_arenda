<?php
/**
 * Получение источников зявок
 */

namespace app\components\actions\equipments;

use app\components\equipments\ApplicationsClass;
use Yii;
use yii\base\Action;

class GetApplicationsSourceAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции получения источников заявок', __METHOD__);

        $result = ApplicationsClass::GetApplicationsSource();

        if (!is_array($result) || !isset($result['status']) || $result['status'] != 'SUCCESS') {
            Yii::error('Ошибка при получении списка источников заявок', __METHOD__);

            if (is_array($result) && isset($result['status']) && $result['status'] === 'ERROR') {
                return $result;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при получении списка источников заявок',
            ];
        }

        Yii::info('Список источников заявок успешно получен', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Список источников заявок успешно получен',
            'data' => $result['data']
        ];
    }
}