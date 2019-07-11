<?php
/**
 * Добавление нового статуса для юр.лица
 */

namespace app\components\actions\status;

use app\components\status\StatusClass;
use Yii;
use yii\base\Action;

class AddStatusAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции добавления нового статуса для клиента', __METHOD__);

        $request = Yii::$app->request;

        $name = $request->getBodyParam('name');
        $color = $request->getBodyParam('color');

        $resultChange = StatusClass::AddStatus($name, $color);

        if (!is_array($resultChange) || !isset($resultChange['status']) || $resultChange['status'] != 'SUCCESS') {
            Yii::error('Ошибка при добавлении нового статуса для клиента', __METHOD__);

            if (is_array($resultChange) && isset($resultChange['status']) && $resultChange['status'] === 'ERROR') {
                return $resultChange;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при добавлении нового статуса для клиента',
            ];
        }

        Yii::info('Статус для клиента успешно добавлен', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Статус успешно добавлен',
        ];
    }
}