<?php
/**
 * Изменение статуса у оборудования
 */

namespace app\components\actions\equipments;

use app\components\equipments\EquipmentsClass;
use Yii;
use yii\base\Action;

class GetEquipmentUpdateStatusAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции получения типов оборудования', __METHOD__);

        $request = Yii::$app->request;

        $equipment_id = $request->getBodyParam('equipment_id');
        $equipment_status = $request->getBodyParam('equipment_status');

        $result = EquipmentsClass::ChangeEquipmentsStatus($equipment_id, $equipment_status);

        if (!is_array($result) || !isset($result['status']) || $result['status'] != 'SUCCESS') {
            Yii::error('Ошибка при изменении статуса оборудования', __METHOD__);

            if (is_array($result) && isset($result['status']) && $result['status'] === 'ERROR') {
                return $result;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при изменении статуса оборудования',
            ];
        }

        Yii::info('Статус успешно изменен', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Статус успешно изменен'
        ];
    }
}