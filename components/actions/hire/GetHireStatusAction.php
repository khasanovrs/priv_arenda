<?php
/**
 * Получение статусов проката
 */

namespace app\components\actions\hire;

use app\components\hire\PayClass;
use Yii;
use yii\base\Action;

class GetHireStatusAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции получения статусов проката', __METHOD__);

        $result = PayClass::GetHireStatus();

        if (!is_array($result) || !isset($result['status']) || $result['status'] != 'SUCCESS') {
            Yii::error('Ошибка при получении списка статусов проката', __METHOD__);

            if (is_array($result) && isset($result['status']) && $result['status'] === 'ERROR') {
                return $result;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при получении списка статусов проката',
            ];
        }

        Yii::info('Список статусов проката успешно получен', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Список статусов проката успешно получен',
            'data' => $result['data']
        ];
    }
}