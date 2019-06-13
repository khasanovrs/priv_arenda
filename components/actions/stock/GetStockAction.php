<?php
/**
 * Получение списка складов
 */

namespace app\components\actions\stock;

use app\components\stock\StockClass;
use Yii;
use yii\base\Action;

class GetStockAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции получения списка складов', __METHOD__);

        $result = StockClass::GetStock();

        if (!is_array($result) || !isset($result['status']) || $result['status'] != 'SUCCESS') {
            Yii::error('Ошибка при получении списка складов', __METHOD__);

            if (is_array($result) && isset($result['status']) && $result['status'] === 'ERROR') {
                return $result;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при получении списка складов',
            ];
        }

        Yii::info('Список складов успешно получен', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Список складов успешно получен',
            'data' => $result['data']
        ];
    }
}