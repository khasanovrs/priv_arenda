<?php
/**
 * добавление нового статуса оборудования
 */

namespace app\components\actions\equipments;

use app\components\equipments\EquipmentsClass;
use Yii;
use yii\base\Action;

class AddEquipmentStatusAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции добавления нового статуса оборудования', __METHOD__);

        $request = Yii::$app->request;

        $name = $request->getBodyParam('name');
        $color = $request->getBodyParam('color');
        $val = $request->getBodyParam('val');

        $resultChange = EquipmentsClass::AddStatus($name, $color, $val);

        if (!is_array($resultChange) || !isset($resultChange['status']) || $resultChange['status'] != 'SUCCESS') {
            Yii::error('Ошибка при добавлении нового статуса для оборудования', __METHOD__);

            if (is_array($resultChange) && isset($resultChange['status']) && $resultChange['status'] === 'ERROR') {
                return $resultChange;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при добавлении нового статуса для оборудования',
            ];
        }

        Yii::info('Статус для оборудования успешно добавлен', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => $resultChange['msg'],
        ];
    }
}