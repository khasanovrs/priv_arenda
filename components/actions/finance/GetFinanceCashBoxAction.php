<?php
/**
 * Получение касс для финансов
 */

namespace app\components\actions\finance;

use app\components\finance\FinanceClass;
use Yii;
use yii\base\Action;

class GetFinanceCashBoxAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции получения списка касс для финансов', __METHOD__);

        $result = FinanceClass::GetFinanceCashBox();

        if (!is_array($result) || !isset($result['status']) || $result['status'] != 'SUCCESS') {
            Yii::error('Ошибка при получении списка касс для финансов', __METHOD__);

            if (is_array($result) && isset($result['status']) && $result['status'] === 'ERROR') {
                return $result;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при получении списка касс для финансов',
            ];
        }

        Yii::info('Список касс для финансов успешно получен', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Список касс для финансов успешно получен',
            'data' => $result['data']
        ];
    }
}