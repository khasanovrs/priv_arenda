<?php
/**
 * Добавление нового статуса проката
 */

namespace app\components\actions\hire;

use app\components\hire\HireClass;
use Yii;
use yii\base\Action;

class AddHireStatusAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции добавления статуса проката', __METHOD__);

        $request = Yii::$app->request;

        $name = $request->getBodyParam('name');
        $color = $request->getBodyParam('color');
        $val = $request->getBodyParam('val');

        $resultChange = HireClass::AddStatus($name, $color, $val);

        if (!is_array($resultChange) || !isset($resultChange['status']) || $resultChange['status'] != 'SUCCESS') {
            Yii::error('Ошибка при добавлении нового статуса для проката', __METHOD__);

            if (is_array($resultChange) && isset($resultChange['status']) && $resultChange['status'] === 'ERROR') {
                return $resultChange;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при добавлении нового статуса для проката',
            ];
        }

        Yii::info('Статус для проката успешно добавлен', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => $resultChange['msg'],
        ];
    }
}