<?php
/**
 * Управление кассами
 */

namespace app\components\CashBox;

use app\models\Finance;
use app\models\FinanceCashbox;
use Yii;

class CashBoxClass
{
    /**
     * Получение касс финансов
     * @return bool|array
     */
    public static function GetFinanceCashBox()
    {
        Yii::info('Запуск функции GetFinanceCashBox', __METHOD__);
        $result = [];

        $equipmentsTypeList = FinanceCashbox::find()->orderBy('id')->all();

        if (!is_array($equipmentsTypeList)) {
            Yii::error('Список касс финансов пуст', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Список касс финансов пуст'
            ];
        }

        /**
         * @var FinanceCashbox $value
         */
        foreach ($equipmentsTypeList as $value) {
            $result[] = [
                'val' => $value->id,
                'name' => $value->name,
                'sum' => $value->sum,
                'zalog' => $value->check_zalog,
                'delivery' => $value->delivery,
            ];
        }

        Yii::info('Список касс финансов получен', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Список касс финансов получен',
            'data' => $result
        ];
    }

    /**
     * Функция добавления кассы
     * @param $name
     * @param $sum
     * @param $val
     * @param zalog
     * @param $delivery
     * @return array|bool
     */
    public static function addCashBox($name, $sum, $val, $zalog, $delivery)
    {
        Yii::info('Запуск функции addCashBox', __METHOD__);

        if ($name === '') {
            Yii::error('Наименование кассы не передано', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Наименование кассы не передано'
            ];
        }

        if ($val !== '') {
            $newCashBox = FinanceCashbox::find()->where('id=:id', [':id' => $val])->one();

            if (!is_object($newCashBox)) {
                Yii::error('Передан некорректный идентификатор, id:' . serialize($val), __METHOD__);

                return [
                    'status' => 'ERROR',
                    'msg' => 'Передан некорректный идентификатор',
                ];
            }
        } else {
            $newCashBox = new FinanceCashbox();
        }

        $newCashBox->name = $name;
        $newCashBox->sum = $sum;
        $newCashBox->check_zalog = $zalog;
        $newCashBox->delivery= $delivery;

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
            'msg' => $val === '' ? 'Касса успешно добавлена' : 'Касса успешно обновлена'
        ];
    }

    /**
     * Функции удаления кассы
     * @param $id
     * @return array
     */
    public static function DeleteCashBox($id)
    {
        Yii::info('Запуск функции удаления кассы', __METHOD__);

        if ($id === '') {
            Yii::error('Идентификатор кассы не передан', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Идентификатор кассы не передан'
            ];
        }

        $check = Finance::find()->where('cashBox_id=:cashBox_id', [':cashBox_id' => $id])->one();

        if (is_object($check)) {
            Yii::error('Данная касса еще используется', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Данная касса еще используется'
            ];
        }

        try {
            FinanceCashbox::deleteAll('id=:id', [':id' => $id]);
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при удалении кассы: ' . serialize($e->getMessage()), __METHOD__);
            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при удалении кассы'
            ];
        }


        Yii::info('Касса успешно удалена', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Касса успешно удалена'
        ];
    }
}