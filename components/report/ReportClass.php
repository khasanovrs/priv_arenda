<?php
/**
 * Управление отчетами
 */

namespace app\components\report;

use app\models\ApplicationEquipment;
use app\models\Applications;
use app\models\Clients;
use app\models\Equipments;
use Yii;

class ReportClass
{
    public static function GetEquipment($branch, $type)
    {
        Yii::info('Запуск функции GetEquipment', __METHOD__);
        $result = [];

        $applications = Applications::find()->where('branch_id=:branch_id', [':branch_id' => $branch])->all();

        if (empty($applications)) {
            Yii::info('Оборудований нет', __METHOD__);
            return [
                'status' => 'SUCCESS',
                'data' => $result
            ];
        }

        /**
         * @var Applications $value
         */
        foreach ($applications as $value) {
            /**
             * @var ApplicationEquipment $apEq
             */
            $apEq = $value->applicationEquipments;

            if (empty($apEq)) {
                continue;
            }

            /**
             * @var Equipments $eq
             */
            $eq = $apEq[0]->equipments;

            $result[] = [
                'name' => $eq->category->name . ' ' . $eq->mark0->name . ' ' . $eq->model,
                'photo' => $eq->photo,
                'params' => '',
                'price' => $eq->price_per_day,
                'eq_id' => $eq->id
            ];
        }

        Yii::info('Оборудования успешно получены', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'data' => $result
        ];
    }

    /**
     * Количество новых клиентов
     * @return array
     */
    public static function GetNewClients()
    {
        Yii::info('Запускк функции GetNewClients', __METHOD__);

        $result = Clients::find()->where('date_create>:date_create', [':date_create' => date('Y-m-01 00:00:00')])->count();

        return [
            'status' => 'SUCCESS',
            'data' => [
                'name' => 'Новых клиентов',
                'img' => '2.svg',
                'result' => $result
            ]
        ];
    }

    /**
     * Количество постоянных клиентов
     * @return array
     */
    public static function GetClients()
    {
        Yii::info('Запускк функции GetNewClients', __METHOD__);

        $result = Clients::find()->count();

        return [
            'status' => 'SUCCESS',
            'data' => [
                'name' => 'Постоянных клиентов',
                'img' => '3.svg',
                'result' => $result
            ]
        ];
    }

    /**
     * Количество просроченных оборудования
     * @return array
     */
    public static function GetPastDueEquipments()
    {
        Yii::info('Запускк функции GetPastDueEquipments', __METHOD__);

        $result = ApplicationEquipment::find()->where('hire_status_id=2')->count();

        return [
            'status' => 'SUCCESS',
            'data' => [
                'name' => 'Просроченные в аренде',
                'img' => '4.svg',
                'result' => $result
            ]
        ];
    }
}