<?php
/**
 * Управление информацией на рабочем столе
 */

namespace app\components\main;

use app\models\ApplicationEquipment;
use app\models\ApplicationPay;
use app\models\Applications;
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

        $debtorSum = 0;
        $allSum = 0;
        $count = 0;

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

        $applicationEquipmentHire = Applications::find()
            ->joinWith('applicationEquipments')
            ->where('application_equipment.status_id in (1,2) and branch_id=:branch and (rent_start < :date_start || rent_end > :date_end)', [':branch' => $branch, ':date_start' => $date_start, ':date_end' => $date_end])
            ->count('DISTINCT applications.id');

        $applicationEquipmentRenewals = Applications::find()
            ->joinWith('applicationEquipments')
            ->where('branch_id=:branch and application_equipment.renewals_date BETWEEN :date_start and :date_end', [':branch' => $branch, ':date_start' => $date_start, ':date_end' => $date_end])
            ->count('DISTINCT applications.id');

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
                $debtorSum += (float)$value->sum - (float)$value->total_paid;
            }
        }

        Yii::info('Получаем средний чек и общая сумма', __METHOD__);

        $payList = ApplicationPay::find()
            ->joinWith(['applicationEquipment','applicationEquipment.application'])
            ->where(['between', 'application_pay.date_create', $date_start, $date_end])
            ->andWhere('applications.branch_id=:branch',[':branch' => $branch])
            ->all();

        if (!empty($payList)) {
            /**
             * @var ApplicationPay $value
             */
            foreach ($payList as $value) {
                if ($value->cashBox0->check_zalog === '1') {
                    continue;
                }

                $allSum += (float)$value->sum;
                $count++;
            }
        }

        $result['debt']['count'] = $debtorSum;
        $result['revenue']['count'] = $allSum;
        $result['average_amount']['count'] = round($allSum !== 0 ? $allSum / $count : 0);
        $result['hire']['count'] = $applicationEquipmentHire;
        $result['renewals']['count'] = $applicationEquipmentRenewals;

        Yii::info('Доходы успешно получены', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Доходы успешно получены',
            'data' => $result
        ];
    }

    /**
     * Получение информации для шапки
     * @param $branch
     * @return array
     */
    public static function getRevenue($branch)
    {
        Yii::info('Запуск функции получении информации для шапки', __METHOD__);

        $allSum = 0;
        $date_start = date('Y-m-d') . ' 00:00:00';
        $date_end = date('Y-m-d') . ' 23:59:59';

        if ($branch === '') {
            Yii::error('Не передан идентификатор филиала, branch: ' . serialize($branch), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не передан идентификатор филиала'
            ];
        }

        if ($branch !== 0) {
            $check_branch = Branch::find()->where('id=:id', [':id' => $branch])->one();

            if (!is_object($check_branch)) {
                Yii::error('Передан некорректный идентификатор филиала, branch:' . serialize($branch), __METHOD__);

                return [
                    'status' => 'ERROR',
                    'msg' => 'Передан некорректный идентификатор филиала',
                ];
            }

            $applicationPayArr = ApplicationPay::find()
                ->joinWith(['application', 'application.applicationEquipments'])
                ->where('applications.branch_id=:branch and application_pay.date_create BETWEEN :date_start and :date_end', [':branch' => $branch, ':date_start' => $date_start, ':date_end' => $date_end])
                ->all();
        } else {
            $applicationPayArr = ApplicationPay::find()
                ->joinWith(['application', 'application.applicationEquipments'])
                ->where('application_pay.date_create BETWEEN :date_start and :date_end', [':date_start' => $date_start, ':date_end' => $date_end])
                ->all();
        }

        if (!empty($applicationPayArr)) {
            /**
             * @var ApplicationPay $value
             */
            foreach ($applicationPayArr as $value) {
                if ($value->cashBox0->check_zalog === '0') {
                    $allSum += (float)$value->sum;
                }
            }
        }

        Yii::info('Доходы успешно получены', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Доходы успешно получены',
            'data' => $allSum
        ];
    }
}