<?php
/**
 * Добавление финансов
 */

namespace app\components\actions\finance;

use app\components\finance\FinanceClass;
use Yii;
use yii\base\Action;

class AddFinanceAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции добавления финансов', __METHOD__);

        $request = Yii::$app->request;

        $id = $request->getBodyParam('id');
        $name = $request->getBodyParam('name');
        $category = $request->getBodyParam('category');
        $type = $request->getBodyParam('type');
        $sum = $request->getBodyParam('sum');
        $cashBox = $request->getBodyParam('cashBox');
        $branch = $request->getBodyParam('branch');

        $result = FinanceClass::addFinance($id, $name, $category, $type, $sum, $cashBox, $branch);

        if (!is_array($result) || !isset($result['status']) || $result['status'] != 'SUCCESS') {
            Yii::error('Ошибка при добавлении финансов', __METHOD__);

            if (is_array($result) && isset($result['status']) && $result['status'] === 'ERROR') {
                return $result;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при добавлении финансов',
            ];
        }

        Yii::info('Финансовая запись успешно добавлена', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Финансовая запись успешно добавлена'
        ];
    }
}