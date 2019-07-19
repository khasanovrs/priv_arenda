<?php
/**
 * Удаление типа оборудования
 */

namespace app\components\actions\equipments;

use app\components\branch\BranchClass;
use app\components\equipments\EquipmentsClass;
use Yii;
use yii\base\Action;

class DeleteEquipmentTypeAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции удаления типа оборудования', __METHOD__);

        $request = Yii::$app->request;

        $id = $request->getBodyParam('id');

        $resultChange = EquipmentsClass::DeleteType($id);

        if (!is_array($resultChange) || !isset($resultChange['status']) || $resultChange['status'] != 'SUCCESS') {
            Yii::error('Ошибка при удалении типа оборудования', __METHOD__);

            if (is_array($resultChange) && isset($resultChange['status']) && $resultChange['status'] === 'ERROR') {
                return $resultChange;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при удалении типа оборудования',
            ];
        }

        Yii::info('Тип оборудования успешно удалена', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Тип оборудования успешно удалена',
        ];
    }
}