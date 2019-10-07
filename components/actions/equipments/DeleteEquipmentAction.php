<?php
/**
 * Удаление оборудования
 */

namespace app\components\actions\equipments;

use app\components\branch\BranchClass;
use app\components\equipments\EquipmentsClass;
use Yii;
use yii\base\Action;

class DeleteEquipmentAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции удаления оборудования', __METHOD__);

        $request = Yii::$app->request;

        $id = $request->getBodyParam('id');

        $resultChange = EquipmentsClass::DeleteEquipment($id);

        if (!is_array($resultChange) || !isset($resultChange['status']) || $resultChange['status'] != 'SUCCESS') {
            Yii::error('Ошибка при удалении оборудования', __METHOD__);

            if (is_array($resultChange) && isset($resultChange['status']) && $resultChange['status'] === 'ERROR') {
                return $resultChange;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при удалении оборудования',
            ];
        }

        Yii::info('Оборудование успешно удалено', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Оборудование успешно удалено',
        ];
    }
}