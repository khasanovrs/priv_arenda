<?php
/**
 * Получение категорий для финансов
 */

namespace app\components\actions\finance;

use app\components\finance\FinanceClass;
use Yii;
use yii\base\Action;

class GetFinanceCategoryAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции получения списка категорий для финансов', __METHOD__);

        $result = FinanceClass::GetFinanceCategory();

        if (!is_array($result) || !isset($result['status']) || $result['status'] != 'SUCCESS') {
            Yii::error('Ошибка при получении списка категорий для финансов', __METHOD__);

            if (is_array($result) && isset($result['status']) && $result['status'] === 'ERROR') {
                return $result;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при получении списка категорий для финансов',
            ];
        }

        Yii::info('Список категорий для финансов успешно получен', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Список категорий для финансов успешно получен',
            'data' => $result['data']
        ];
    }
}