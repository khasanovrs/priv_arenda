<?php
/**
 * Получение списка полей для проката
 */

namespace app\components\actions\hire;

use app\components\applications\ApplicationsClass;
use app\components\hire\PayClass;
use Yii;
use yii\base\Action;

class GetHireFieldAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции получения списка полей для проката', __METHOD__);

        $result = PayClass::GetHireFields();

        if (!is_array($result) || !isset($result['status']) || $result['status'] != 'SUCCESS') {
            Yii::error('Ошибка при получении списка полей для проката', __METHOD__);

            if (is_array($result) && isset($result['status']) && $result['status'] === 'ERROR') {
                return $result;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при получении списка полей для проката',
            ];
        }

        Yii::info('Список полей для проката успешно получены', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Список полей для проката успешно получены',
            'data' => $result['data']
        ];
    }
}