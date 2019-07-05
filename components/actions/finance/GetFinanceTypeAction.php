<?php
/**
 * Получение типов для финансов
 */

namespace app\components\actions\finance;

use app\components\finance\FinanceClass;
use Yii;
use yii\base\Action;

class GetFinanceTypeAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции получения списка типов для финансов', __METHOD__);

        $result = FinanceClass::GetFinanceType();

        if (!is_array($result) || !isset($result['status']) || $result['status'] != 'SUCCESS') {
            Yii::error('Ошибка при получении списка типов для финансов', __METHOD__);

            if (is_array($result) && isset($result['status']) && $result['status'] === 'ERROR') {
                return $result;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при получении списка типов для финансов',
            ];
        }

        Yii::info('Список типов для финансов успешно получен', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Список типов для финансов успешно получен',
            'data' => $result['data']
        ];
    }
}