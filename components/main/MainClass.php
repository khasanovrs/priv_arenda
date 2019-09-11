<?php
/**
 * Управление информацией на рабочем столе
 */

namespace app\components\main;

use app\models\ApplicationEquipment;
use app\models\ApplicationPay;
use app\models\Branch;
use Yii;

class MainClass
{
    /**
     * Получение информации для рабочего стола
     * @param $branch
     * @param $date_start
     * @param $date_end
     * @return array
     */
    public static function getIncome($branch, $date_start, $date_end)
    {
        Yii::info('Запуск функции получении доходов', __METHOD__);

        /*выручка за период(по умолчанию сегодня),
        количество прокатов,
        средний чек,
        количество продлений,
        сумма долгов*/

        $result = [
            'sum' => ''
        ];

        if ($branch === '') {
            Yii::error('Не передан идентификатор филиала, branch: ' . serialize($branch), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не передан идентификатор филиала'
            ];
        }

        $check_branch = Branch::find()->where('id=:id', [':id' => $branch])->one();

        if (!is_object($check_branch)) {
            Yii::error('Передан некорректный идентификатор филиала, branch:' . serialize($branch), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Передан некорректный идентификатор филиала',
            ];
        }

        $date_start .= ' 00:00:00';
        $date_end .= ' 23:59:59';

        $applicationEquipment = ApplicationEquipment::find()
            ->joinWith('application')
            ->where('applications.branch_id=:branch and applications.date_create BETWEEN :date_start and :date_end', [':branch' => $branch, ':date_start' => $date_start, ':date_end' => $date_end])
            ->all();

        if (!is_array($applicationEquipment)) {
            Yii::error('Список оборудований пуст', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Список оборудований пуст'
            ];
        }

        $eqArr = [];
        /**
         * @var ApplicationEquipment $value
         */
        foreach ($applicationEquipment as $value) {
            array_push($eqArr,$value->id);
        }


        Yii::info('Получаем средний чек', __METHOD__);

        $sum = ApplicationPay::find()->where(['between', 'date_create', $date_start, $date_end])->all();

        $allSum = 0;
        $count = 0;
        if (!empty($sum)) {
            /**
             * @var ApplicationPay $value
             */
            foreach ($sum as $value) {
                $allSum += (float)$value->sum;
                $count++;
            }

            $result['sum'] = $allSum / $count;
        }


        $date_start = date('Y-m-' . '01' . ' 00:00:00');
        $date_end = date('Y-m-' . '31' . ' 23:59:59');

        $applications = ApplicationPay::find()->where(['between', 'date_create', $date_start, $date_end])->all();

        if (empty($applications)) {
            Yii::info('Доходов за текущий месяц нет', __METHOD__);

            return [
                'status' => 'SUCCESS',
                'msg' => 'Доходов за текущий месяц нет',
                'data' => $result
            ];
        }

        /**
         * @var ApplicationPay $value
         */
        foreach ($applications as $value) {
            $result['month'] += $value->sum;

            if (date('d', strtotime($value->date_create)) === date('d')) {
                $result['sum_day'] += $value->sum;
            }
        }

        Yii::info('Доходы успешно получены', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Доходы успешно получены',
            'date' => $result
        ];
    }
}