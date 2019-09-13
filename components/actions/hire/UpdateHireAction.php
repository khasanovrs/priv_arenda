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
        $delivery = $request->getBodyParam('delivery');
        $sale = $request->getBodyParam('sale');
        $rent_start = $request->getBodyParam('rent_start');
        $rent_end = $request->getBodyParam('rent_end');
        $comment = $request->getBodyParam('comment');

        $result = HireClass::UpdateHire($id, $comment, $delivery, $sale, $rent_start, $rent_end);

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