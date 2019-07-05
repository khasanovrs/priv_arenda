<?php
/**
 * Удаление статуса оборудования
 */

namespace app\components\actions\equipments;

use app\components\equipments\EquipmentsClass;
use Yii;
use yii\base\Action;

class DeleteEquipmentStatusAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции удаления статуса оборудования', __METHOD__);

        $request = Yii::$app->request;

        $id = $request->getBodyParam('id');

        $resultChange = EquipmentsClass::DeleteStatus($id);

        if (!is_array($resultChange) || !isset($resultChange['status']) || $resultChange['status'] != 'SUCCESS') {
            Yii::error('Ошибка при удалении статуса для оборудования', __METHOD__);

            if (is_array($resultChange) && isset($resultChange['status']) && $resultChange['status'] === 'ERROR') {
                return $resultChange;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при удалении статуса для оборудования',
            ];
        }

        Yii::info('Статус для оборудования успешно удален', __METHOD__);

        return [
            'status' => 'ОК',
            'msg' => 'Статус успешно удален',
        ];
    }
}