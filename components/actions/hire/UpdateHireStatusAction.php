<?php
/**
 * Изменение статусов проката
 */

namespace app\components\actions\hire;

use app\components\hire\HireClass;
use Yii;
use yii\base\Action;

class UpdateHireStatusAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции изменения статуса проката', __METHOD__);

        $request = Yii::$app->request;

        $id = $request->getBodyParam('id');
        $status = $request->getBodyParam('status');

        $result = HireClass::UpdateHireStatus($id, $status);

        if (!is_array($result) || !isset($result['status']) || $result['status'] != 'SUCCESS') {
            Yii::error('Ошибка при изменении статуса проката', __METHOD__);

            if (is_array($result) && isset($result['status']) && $result['status'] === 'ERROR') {
                return $result;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при изменении статуса проката',
            ];
        }

        Yii::info('Статус проката успешно изменен', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Статус проката успешно изменен'
        ];
    }
}