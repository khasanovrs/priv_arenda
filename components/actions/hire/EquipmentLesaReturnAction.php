<?php
/**
 * Возврат лесов на склад
 */

namespace app\components\actions\hire;

use app\components\hire\HireClass;
use Yii;
use yii\base\Action;

class EquipmentLesaReturnAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции возврата лесов на склад', __METHOD__);

        $request = Yii::$app->request;

        $id = $request->getBodyParam('id');

        $result = HireClass::lesaReturn($id);

        if (!is_array($result) || !isset($result['status']) || $result['status'] != 'SUCCESS') {
            Yii::error('Ошибка при возврате лесов на склад', __METHOD__);

            if (is_array($result) && isset($result['status']) && $result['status'] === 'ERROR') {
                return $result;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при возврате лесов на склад',
            ];
        }

        Yii::info('Леса успешно вернули на склад', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Леса успешно вернули на склад'
        ];
    }
}