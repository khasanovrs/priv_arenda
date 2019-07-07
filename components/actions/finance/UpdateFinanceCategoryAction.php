<?php
/**
 * Редактирование категории финансов
 */

namespace app\components\actions\finance;

use app\components\finance\FinanceClass;
use Yii;
use yii\base\Action;

class UpdateFinanceCategoryAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции изменения категории финансов', __METHOD__);

        $request = Yii::$app->request;

        $finance_id = $request->getBodyParam('finance_id');
        $finance_category = $request->getBodyParam('finance_category');

        $resultChange = FinanceClass::UpdateStatus($finance_id, $finance_category);

        if (!is_array($resultChange) || !isset($resultChange['status']) || $resultChange['status'] != 'SUCCESS') {
            Yii::error('Ошибка при изменения категории финансов', __METHOD__);

            if (is_array($resultChange) && isset($resultChange['status']) && $resultChange['status'] === 'ERROR') {
                return $resultChange;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при изменении категории финансов',
            ];
        }

        Yii::info('Категория успешно изменена', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Категория успешно изменена',

        ];
    }
}