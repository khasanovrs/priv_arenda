<?php
/**
 * Изменение информации проката
 */

namespace app\components\actions\hire;

use app\components\hire\HireClass;
use Yii;
use yii\base\Action;

class UpdateHireAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции изменения информации проката', __METHOD__);

        $request = Yii::$app->request;

        $id = $request->getBodyParam('id');
        $status = $request->getBodyParam('status');
        $comment = $request->getBodyParam('comment');
        $total_paid = $request->getBodyParam('total_paid');

        $result = HireClass::UpdateHire($id, $status, $comment, $total_paid);

        if (!is_array($result) || !isset($result['status']) || $result['status'] != 'SUCCESS') {
            Yii::error('Ошибка при изменении информации проката', __METHOD__);

            if (is_array($result) && isset($result['status']) && $result['status'] === 'ERROR') {
                return $result;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при изменении информации проката',
            ];
        }

        Yii::info('Информация проката успешно изменена', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Информация проката успешно изменена'
        ];
    }
}