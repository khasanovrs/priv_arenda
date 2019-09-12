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

        $result = [
            'revenue' => ['name' => 'Выручка', 'count' => '0', 'currency' => true],
            'average_amount' => ['name' => 'Средний чек', 'count' => '0', 'currency' => true],
            'debt' => ['name' => 'Сумма долга', 'count' => '0', 'currency' => true],
            'renewals' => ['name' => 'Количество продлений', 'count' => 0, 'currency' => false],
            'hire' => ['name' => 'Количество прокатов', 'count' => 0, 'currency' => false],
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

        $applicationEquipmentHire = ApplicationEquipment::find()
            ->joinWith('application')
            ->where('applications.branch_id=:branch and hire_date BETWEEN :date_start and :date_end', [':branch' => $branch, ':date_start' => $date_start, ':date_end' => $date_end])
            ->count();

        $result['hire']['count'] = $applicationEquipmentHire;


        $applicationEquipmentRenewals = ApplicationEquipment::find()
            ->joinWith('application')
            ->where('applications.branch_id=:branch and renewals_date BETWEEN :date_start and :date_end', [':branch' => $branch, ':date_start' => $date_start, ':date_end' => $date_end])
            ->count();

        $result['renewals']['count'] = $applicationEquipmentRenewals;


        $applicationEquipment = ApplicationEquipment::find()
            ->joinWith('application')
            ->where('applications.branch_id=:branch and renewals_date BETWEEN :date_start and :date_end', [':branch' => $branch, ':date_start' => $date_start, ':date_end' => $date_end])
            ->all();

        if (!is_array($applicationEquipment)) {
            Yii::error('Список оборудований пуст', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Список оборудований пуст'
            ];
        }

        /**
         * @var ApplicationEquipment $value
         */
        foreach ($applicationEquipment as $value) {
            if ($value->hire_state_id === 5) {
                array_push($debtor, $value->id);
            }
        }

        Yii::info('Получаем средний чек и общая сумма', __METHOD__);

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

            $result['revenue']['count'] = $allSum;
            $result['average_amount']['count'] = $allSum / $count;
        }

        Yii::info('Доходы успешно получены', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Доходы успешно получены',
            'data' => $result
        ];
    }
}