<?php
/**
 * Добавление новой заявки
 */

namespace app\components\actions\pay;

use app\components\applications\ApplicationsClass;
use app\components\pay\PayClass;
use Yii;
use yii\base\Action;

class AddPayAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции добавления платежа', __METHOD__);

        $request = Yii::$app->request;

        $eq_id = $request->getBodyParam('eq_app_id');
        $sum = $request->getBodyParam('sum');

        $result = PayClass::AddPay($eq_id, $sum);

        if (!is_array($result) || !isset($result['status']) || $result['status'] != 'SUCCESS') {
            Yii::error('Ошибка при добавлении платежа', __METHOD__);

            if (is_array($result) && isset($result['status']) && $result['status'] === 'ERROR') {
                return $result;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при добавлении платежа',
            ];
        }

        $result = PayClass::getPayList($eq_id);

        if (!is_array($result) || !isset($result['status']) || $result['status'] != 'SUCCESS') {
            Yii::error('Ошибка при получении платежей', __METHOD__);

            if (is_array($result) && isset($result['status']) && $result['status'] === 'ERROR') {
                return $result;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при добавлении платежа',
            ];
        }

        Yii::info('Платеж успешно добавлен', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Платеж успешно добавлен'
        ];
    }
}