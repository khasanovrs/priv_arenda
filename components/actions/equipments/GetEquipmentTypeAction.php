<?php
/**
 * Получение списка типов оборудования
 */

namespace app\components\actions\equipments;

use app\components\equipments\EquipmentsClass;
use Yii;
use yii\base\Action;

class GetEquipmentTypeAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции получения типов оборудования', __METHOD__);

        $result = EquipmentsClass::GetEquipmentsType();

        if (!is_array($result) || !isset($result['status']) || $result['status'] != 'SUCCESS') {
            Yii::error('Ошибка при получении списка типов оборудования', __METHOD__);

            if (is_array($result) && isset($result['status']) && $result['status'] === 'ERROR') {
                return $result;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при получении списка типов оборудования',
            ];
        }

        Yii::info('Список типов оборудования успешно получен', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Список типов оборудования успешно получен',
            'data' => $result['data']
        ];
    }
}