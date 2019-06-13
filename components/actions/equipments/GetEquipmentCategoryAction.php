<?php
/**
 * Получение списка категорий оборудования
 */

namespace app\components\actions\equipments;

use app\components\equipments\EquipmentsClass;
use Yii;
use yii\base\Action;

class GetEquipmentCategoryAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции получения категорий оборудования', __METHOD__);

        $result = EquipmentsClass::GetEquipmentsCategory();

        if (!is_array($result) || !isset($result['status']) || $result['status'] != 'SUCCESS') {
            Yii::error('Ошибка при получении списка категорий оборудования', __METHOD__);

            if (is_array($result) && isset($result['status']) && $result['status'] === 'ERROR') {
                return $result;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при получении списка категорий оборудования',
            ];
        }

        Yii::info('Список категорий оборудования успешно получен', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Список категорий оборудования успешно получен',
            'data' => $result['data']
        ];
    }
}