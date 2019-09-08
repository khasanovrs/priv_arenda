<?php
/**
 * Получение состонияний проката
 */

namespace app\components\actions\hire;

use app\components\hire\HireClass;
use Yii;
use yii\base\Action;

class GetHireStateAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции получения состояний проката', __METHOD__);

        $result = HireClass::GetHireState();

        if (!is_array($result) || !isset($result['status']) || $result['status'] != 'SUCCESS') {
            Yii::error('Ошибка при получении списка состояний проката', __METHOD__);

            if (is_array($result) && isset($result['status']) && $result['status'] === 'ERROR') {
                return $result;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при получении списка состояний проката',
            ];
        }

        Yii::info('Список состояний проката успешно получен', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Список состояний проката успешно получен',
            'data' => $result['data']
        ];
    }
}