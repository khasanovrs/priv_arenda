<?php
/**
 * Получение списка финансов
 */

namespace app\components\actions\finance;

use app\components\finance\FinanceClass;
use Yii;
use yii\base\Action;

class GetFinanceAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции получения списка финансов', __METHOD__);

        $request = Yii::$app->request;

        $like = $request->getBodyParam('like');
        $category = $request->getBodyParam('category');
        $cashBox = $request->getBodyParam('cashBox');
        $type = $request->getBodyParam('type');
        $sum_start = $request->getBodyParam('sum_start');
        $sum_end = $request->getBodyParam('sum_end');
        $date_start = $request->getBodyParam('date_start');
        $date_end = $request->getBodyParam('date_end');

        $result = FinanceClass::GetFinance($like,$category,$cashBox,$type,$sum_start,$sum_end,$date_start,$date_end);

        if (!is_array($result) || !isset($result['status']) || $result['status'] != 'SUCCESS') {
            Yii::error('Ошибка при получении списка финансов', __METHOD__);

            if (is_array($result) && isset($result['status']) && $result['status'] === 'ERROR') {
                return $result;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при получении списка финансов',
            ];
        }

        Yii::info('Список финансов успешно получен', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Список финансов успешно получен',
            'data' => $result['data']
        ];
    }
}