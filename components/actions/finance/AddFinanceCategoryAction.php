<?php
/**
 * Добавление категории
 */

namespace app\components\actions\finance;

use app\components\finance\FinanceClass;
use Yii;
use yii\base\Action;

class AddFinanceCategoryAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции добавления категории', __METHOD__);

        $request = Yii::$app->request;

        $branch = $request->getBodyParam('name');
        $val = $request->getBodyParam('val');

        $resultChange = FinanceClass::AddCategory($branch, $val);

        if (!is_array($resultChange) || !isset($resultChange['status']) || $resultChange['status'] != 'SUCCESS') {
            Yii::error('Ошибка при добавлении новой категории', __METHOD__);

            if (is_array($resultChange) && isset($resultChange['status']) && $resultChange['status'] === 'SUCCESS') {
                return $resultChange;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при добавлении нового категории',
            ];
        }

        Yii::info('Категория успешно добавлена', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => $resultChange['msg'],
        ];
    }
}