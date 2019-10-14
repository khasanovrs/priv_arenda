<?php
/**
 * Возврат оборудования на склад
 */

namespace app\components\actions\hire;

use app\components\hire\HireClass;
use Yii;
use yii\base\Action;

class EquipmentReturnAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции возврата оборудования на склад', __METHOD__);

        $request = Yii::$app->request;

        $id = $request->getBodyParam('id');

        $result = HireClass::equipmentReturn($id);

        if (!is_array($result) || !isset($result['status']) || $result['status'] != 'SUCCESS') {
            Yii::error('Ошибка при возврате оборудования на склад', __METHOD__);

            if (is_array($result) && isset($result['status']) && $result['status'] === 'ERROR') {
                return $result;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при возврате оборудования на склад',
            ];
        }

        Yii::info('Оборудование успешно вернули на склад', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Оборудование успешно вернули на склад'
        ];
    }
}