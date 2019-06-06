<?php
/**
 * Получение списка статусов
 */

namespace app\components\actions\equipments;

use app\components\equipments\EquipmentsClass;
use Yii;
use yii\base\Action;

class GetEquipmentStatusAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции получения статусов', __METHOD__);

        $result = EquipmentsClass::GetEquipmentsStatus();

        if (!is_array($result) || !isset($result['status']) || $result['status'] != 'SUCCESS') {
            Yii::error('Ошибка при получении списка статусов оборудований', __METHOD__);

            if (is_array($result) && isset($result['status']) && $result['status'] === 'ERROR') {
                return $result;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при получении списка статусов оборудований',
            ];
        }

        Yii::info('Список статусов оборудований успешно получен', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Список статусов оборудований успешно получен',
            'data' => $result['data']
        ];
    }
}