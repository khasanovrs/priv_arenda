<?php
/**
 * Изменение списка полей для проката лесов
 */

namespace app\components\actions\hire;

use app\components\hire\HireClass;
use Yii;
use yii\base\Action;

class ChangeHireLesaFieldAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции изменения списка полей для проката лесов', __METHOD__);

        $request = Yii::$app->request;

        $params = $request->getBodyParam('data');

        $result = HireClass::ChangeHireLesaFields($params);

        if (!is_array($result) || !isset($result['status']) || $result['status'] != 'SUCCESS') {
            Yii::error('Ошибка при изменении списка полей для проката лесов', __METHOD__);

            if (is_array($result) && isset($result['status']) && $result['status'] === 'ERROR') {
                return $result;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при изменении списка полей для проката лесов',
            ];
        }

        Yii::info('Списки полей для проката лесов успешно изменены', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Списки полей для проката лесов успешно изменены'
        ];
    }
}