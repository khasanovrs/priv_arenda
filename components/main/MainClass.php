<?php
/**
 * Управление информацией на рабочем столе
 */

namespace app\components\main;

use app\models\ApplicationPay;
use app\models\Applications;
use app\models\Branch;
use Codeception\Application;
use Yii;

class MainClass
{
    public static function getIncome($branch)
    {
        Yii::info('Запуск функции получении доходов', __METHOD__);

        $result = [
            'day' => 0,
            'month' => 0
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