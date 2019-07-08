<?php
/**
 * Получение детальной информации по финансу
 */

namespace app\components\actions\finance;

use app\components\finance\FinanceClass;
use Yii;
use yii\base\Action;

class GetFinanceInfoAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции получения детальной информации по финансу', __METHOD__);

        $request = Yii::$app->request;

        $financeId = $request->getBodyParam('financeId');

        $result = FinanceClass::GetFinanceInfo($financeId);

        if (!is_array($result) || !isset($result['status']) || $result['status'] != 'SUCCESS') {
            Yii::error('Ошибка при получении детальной информации по финансу', __METHOD__);

            if (is_array($result) && isset($result['status']) && $result['status'] === 'ERROR') {
                return $result;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при получении детальной информации по финансу',
            ];
        }

        Yii::info('Детальная информация по финансу успешно получена', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Детальная информация по финансу успешно получена',
            'data' => $result['data']
        ];
    }
}