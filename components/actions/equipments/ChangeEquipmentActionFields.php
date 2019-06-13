<?php
/**
 * Изменение отображения полей для оборудования
 */

namespace app\components\actions\equipments;

use app\components\equipments\EquipmentsClass;
use Yii;
use yii\base\Action;

class ChangeEquipmentActionFields extends Action
{
    public function run()
    {
        Yii::info('Запуск функции изменения отображения полей для оборудования', __METHOD__);

        $request = Yii::$app->request;

        $params = $request->getBodyParam('data');

        $result = EquipmentsClass::ChangeEquipmentFields($params);

        if (!is_array($result) || !isset($result['status']) || $result['status'] != 'SUCCESS') {
            Yii::error('Ошибка при изменении полей для оборудования', __METHOD__);

            if (is_array($result) && isset($result['status']) && $result['status'] === 'ERROR') {
                return $result;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при изменении полей для оборудования',
            ];
        }

        Yii::info('Поля успешно изменены', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Поля успешно изменены',
            'data' => []
        ];
    }
}