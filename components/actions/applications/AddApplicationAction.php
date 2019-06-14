<?php
/**
 * Добавление новой заявки
 */

namespace app\components\actions\applications;

use app\components\applications\ApplicationsClass;
use Yii;
use yii\base\Action;

class AddApplicationAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции добавления новой заявки', __METHOD__);

        $request = Yii::$app->request;

        $client_id = $request->getBodyParam('client_id');
        $equipments = $request->getBodyParam('equipments');
        $typeLease = $request->getBodyParam('typeLease');
        $sale = $request->getBodyParam('sale');
        $rent_start = $request->getBodyParam('rent_start');
        $rent_end = $request->getBodyParam('rent_end');
        $delivery = $request->getBodyParam('delivery');
        $sum = $request->getBodyParam('sum');
        $delivery_sum = $request->getBodyParam('delivery_sum');
        $status = $request->getBodyParam('status');
        $comment = $request->getBodyParam('comment');
        $branch = $request->getBodyParam('branch');

        $result = ApplicationsClass::AddApplication($client_id, $equipments, $typeLease, $sale, $rent_start, $rent_end, $delivery, $sum, $delivery_sum, $status, $comment, $branch);

        if (!is_array($result) || !isset($result['status']) || $result['status'] != 'SUCCESS') {
            Yii::error('Ошибка при добавлении заявки', __METHOD__);

            if (is_array($result) && isset($result['status']) && $result['status'] === 'ERROR') {
                return $result;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при добавлении заявки',
            ];
        }

        Yii::info('Заявка успешно добавлена', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Заявка успешно добавлена'
        ];
    }
}