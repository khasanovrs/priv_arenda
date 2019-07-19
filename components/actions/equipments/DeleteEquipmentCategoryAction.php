<?php
/**
 * Удаление категории оборудования
 */

namespace app\components\actions\equipments;

use app\components\branch\BranchClass;
use app\components\equipments\EquipmentsClass;
use Yii;
use yii\base\Action;

class DeleteEquipmentCategoryAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции удаления категории оборудования', __METHOD__);

        $request = Yii::$app->request;

        $id = $request->getBodyParam('id');

        $resultChange = EquipmentsClass::DeleteCategory($id);

        if (!is_array($resultChange) || !isset($resultChange['status']) || $resultChange['status'] != 'SUCCESS') {
            Yii::error('Ошибка при удалении категории оборудования', __METHOD__);

            if (is_array($resultChange) && isset($resultChange['status']) && $resultChange['status'] === 'ERROR') {
                return $resultChange;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при удалении категории оборудования',
            ];
        }

        Yii::info('Категория оборудования успешно удалена', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Категория оборудования успешно удалена',
        ];
    }
}