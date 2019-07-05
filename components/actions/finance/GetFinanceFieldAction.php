<?php
/**
 * Получение списка полей для финансов
 */

namespace app\components\actions\finance;

use app\components\finance\FinanceClass;
use Yii;
use yii\base\Action;

class GetFinanceFieldAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции получения списка полей для финансов', __METHOD__);

        $result = FinanceClass::GetFinanceFields();

        if (!is_array($result) || !isset($result['status']) || $result['status'] != 'SUCCESS') {
            Yii::error('Ошибка при получении списка полей для финансов', __METHOD__);

            if (is_array($result) && isset($result['status']) && $result['status'] === 'ERROR') {
                return $result;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при получении списка полей для финансов',
            ];
        }

        Yii::info('Список полей для финансов успешно получен', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Список полей для финансов успешно получен',
            'data' => $result['data']
        ];
    }
}