<?php
/**
 * Закрытие проката
 */

namespace app\components\actions\hire;

use app\components\hire\HireClass;
use Yii;
use yii\base\Action;

class CloseHireAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции закрытия проката', __METHOD__);

        $request = Yii::$app->request;

        $id = $request->getBodyParam('id');

        $result = HireClass::closeHire($id);

        if (!is_array($result) || !isset($result['status']) || $result['status'] != 'SUCCESS') {
            Yii::error('Ошибка при закрытии проката', __METHOD__);

            if (is_array($result) && isset($result['status']) && $result['status'] === 'ERROR') {
                return $result;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при закрытии проката',
            ];
        }

        Yii::info('Прокат успешно обновлен', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => $result['msg']
        ];
    }
}