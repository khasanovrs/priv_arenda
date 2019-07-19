<?php
/**
 * добавление новой марки
 */

namespace app\components\actions\equipments;

use app\components\equipments\EquipmentsClass;
use Yii;
use yii\base\Action;

class AddEquipmentMarkAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции добавления новой марки оборудования', __METHOD__);

        $request = Yii::$app->request;

        $name = $request->getBodyParam('name');
        $val = $request->getBodyParam('val');

        $resultChange = EquipmentsClass::AddMark($name, $val);

        if (!is_array($resultChange) || !isset($resultChange['status']) || $resultChange['status'] != 'SUCCESS') {
            Yii::error('Ошибка при добавлении новой марки для оборудования', __METHOD__);

            if (is_array($resultChange) && isset($resultChange['status']) && $resultChange['status'] === 'ERROR') {
                return $resultChange;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при добавлении новой марки для оборудования',
            ];
        }

        Yii::info('Тип для оборудования успешно добавлен', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => $resultChange['msg'],
        ];
    }
}