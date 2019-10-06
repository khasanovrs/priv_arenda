<?php
/**
 * Добавление кассы
 */

namespace app\components\actions\cashBox;

use app\components\CashBox\CashBoxClass;
use Yii;
use yii\base\Action;

class AddCashBoxAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции добавления кассы', __METHOD__);

        $request = Yii::$app->request;

        $name = $request->getBodyParam('name');
        $sum = $request->getBodyParam('sum');
        $val = $request->getBodyParam('val');
        $zalog = $request->getBodyParam('zalog');

        $resultChange = CashBoxClass::AddCashBox($name, $sum, $val, $zalog);

        if (!is_array($resultChange) || !isset($resultChange['status']) || $resultChange['status'] != 'SUCCESS') {
            Yii::error('Ошибка при добавлении новой кассы', __METHOD__);

            if (is_array($resultChange) && isset($resultChange['status']) && $resultChange['status'] === 'SUCCESS') {
                return $resultChange;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при добавлении новой кассы',
            ];
        }

        Yii::info('Касса успешно добавлена', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => $resultChange['msg'],
        ];
    }
}