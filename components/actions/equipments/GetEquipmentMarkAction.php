<?php
/**
 * Получение списка марок оборудования
 */

namespace app\components\actions\equipments;

use app\components\equipments\EquipmentsClass;
use Yii;
use yii\base\Action;

class GetEquipmentMarkAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции получения марок оборудования', __METHOD__);

        $result = EquipmentsClass::GetEquipmentsMark();

        if (!is_array($result) || !isset($result['status']) || $result['status'] != 'SUCCESS') {
            Yii::error('Ошибка при получении списка марок оборудования', __METHOD__);

            if (is_array($result) && isset($result['status']) && $result['status'] === 'ERROR') {
                return $result;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при получении списка марок оборудования',
            ];
        }

        Yii::info('Список марок оборудований успешно получен', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Список марок оборудований успешно получен',
            'data' => $result['data']
        ];
    }
}