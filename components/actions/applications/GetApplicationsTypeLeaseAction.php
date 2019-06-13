<?php
/**
 * Получение списка типов аренды
 */

namespace app\components\actions\applications;

use app\components\applications\ApplicationsClass;
use Yii;
use yii\base\Action;

class GetApplicationsTypeLeaseAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции получения списка типов аренды', __METHOD__);

        $result = ApplicationsClass::GetApplicationsTypeLease();

        if (!is_array($result) || !isset($result['status']) || $result['status'] != 'SUCCESS') {
            Yii::error('Ошибка при получении списка типов аренды', __METHOD__);

            if (is_array($result) && isset($result['status']) && $result['status'] === 'ERROR') {
                return $result;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при получении списка типов аренды',
            ];
        }

        Yii::info('Список типов аренды успешно получен', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Список типов аренды успешно получен',
            'data' => $result['data']
        ];
    }
}