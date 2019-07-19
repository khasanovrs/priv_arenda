<?php
/**
 * Удаление марки оборудования
 */

namespace app\components\actions\equipments;

use app\components\branch\BranchClass;
use app\components\equipments\EquipmentsClass;
use Yii;
use yii\base\Action;

class DeleteEquipmentMarkAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции удаления марки оборудования', __METHOD__);

        $request = Yii::$app->request;

        $id = $request->getBodyParam('id');

        $resultChange = EquipmentsClass::DeleteMark($id);

        if (!is_array($resultChange) || !isset($resultChange['status']) || $resultChange['status'] != 'SUCCESS') {
            Yii::error('Ошибка при удалении марки оборудования', __METHOD__);

            if (is_array($resultChange) && isset($resultChange['status']) && $resultChange['status'] === 'ERROR') {
                return $resultChange;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при удалении марки оборудования',
            ];
        }

        Yii::info('Марка оборудования успешно удалена', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Марка оборудования успешно удалена',
        ];
    }
}