<?php
/**
 * Получение списка полей для проката лесов
 */

namespace app\components\actions\hire;

use app\components\hire\HireClass;
use Yii;
use yii\base\Action;

class GetHireLesaFieldAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции получения списка полей для проката лесов', __METHOD__);

        $result = HireClass::GetHireLesaFields();

        if (!is_array($result) || !isset($result['status']) || $result['status'] != 'SUCCESS') {
            Yii::error('Ошибка при получении списка полей для проката лесов', __METHOD__);

            if (is_array($result) && isset($result['status']) && $result['status'] === 'ERROR') {
                return $result;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при получении списка полей для проката лесов',
            ];
        }

        Yii::info('Список полей для проката лесов успешно получены', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Список полей для проката лесов успешно получены',
            'data' => $result['data']
        ];
    }
}