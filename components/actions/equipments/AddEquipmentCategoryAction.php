<?php
/**
 * добавление новой категории
 */

namespace app\components\actions\equipments;

use app\components\equipments\EquipmentsClass;
use Yii;
use yii\base\Action;

class AddEquipmentCategoryAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции добавления новой категории оборудования', __METHOD__);

        $request = Yii::$app->request;

        $name = $request->getBodyParam('name');
        $val = $request->getBodyParam('val');

        $resultChange = EquipmentsClass::AddCategory($name, $val);

        if (!is_array($resultChange) || !isset($resultChange['status']) || $resultChange['status'] != 'SUCCESS') {
            Yii::error('Ошибка при добавлении нновой категории для оборудования', __METHOD__);

            if (is_array($resultChange) && isset($resultChange['status']) && $resultChange['status'] === 'ERROR') {
                return $resultChange;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при добавлении новой категории для оборудования',
            ];
        }

        Yii::info('Категория для оборудования успешно добавлен', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => $resultChange['msg'],
        ];
    }
}