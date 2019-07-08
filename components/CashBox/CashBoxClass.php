<?php
/**
 * Управление кассами
 */

namespace app\components\CashBox;

use app\models\FinanceCashbox;
use Yii;

class CashBoxClass
{
    public static function addCashBox($name, $sum)
    {
        Yii::info('Запуск функции addCashBox', __METHOD__);

        if ($name==='') {
            Yii::error('Наименование кассы не передано', __METHOD__);

            return [
                'status' => 'SUCCESS',
                'msg' => 'Наименование кассы не передано'
            ];
        }

        $newCashBox = new FinanceCashbox();

        $newCashBox->name = $name;
        $newCashBox->sum= $sum;

        try {
            if (!$newCashBox->save(false)) {
                Yii::error('Ошибка при добавлении новой кассы: ' . serialize($newCashBox->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при добавлении новой кассы: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        return [
            'status' => 'SUCCESS',
            'msg' => 'Касса успешно добавлена'
        ];
    }
}