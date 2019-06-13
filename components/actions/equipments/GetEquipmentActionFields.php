<?php
/**
 * Получение списка полей для оборудования
 */

namespace app\components\actions\equipments;

use app\components\equipments\EquipmentsClass;
use Yii;
use yii\base\Action;

class GetEquipmentActionFields extends Action
{
    public function run()
    {
        Yii::info('Запуск функции получения списка полей для оборудования', __METHOD__);

        $result = EquipmentsClass::GetEquipmentFields();

        if (!is_array($result) || !isset($result['status']) || $result['status'] != 'SUCCESS') {
            Yii::error('Ошибка при получении списка полей для оборудования', __METHOD__);

            if (is_array($result) && isset($result['status']) && $result['status'] === 'ERROR') {
                return $result;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при получении списка полей для оборудования',
            ];
        }

        Yii::info('Список полей для оборудования успешно получен', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Список полей для оборудования успешно получен',
            'data' => $result['data']
        ];
    }
}