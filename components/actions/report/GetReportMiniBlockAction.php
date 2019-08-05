<?php
/**
 * Получение цифр для виджетов
 */

namespace app\components\actions\report;

use app\components\report\ReportClass;
use Yii;
use yii\base\Action;

class GetReportMiniBlockAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции получения списка оборудования', __METHOD__);

        $newClients = ReportClass::GetNewClients();
        if (!is_array($newClients) || !isset($newClients['status']) || $newClients['status'] != 'SUCCESS') {
            Yii::error('Ошибка при получении новых клиентов', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при получении новых клиентов',
            ];
        }

        $clients = ReportClass::GetClients();
        if (!is_array($clients) || !isset($clients['status']) || $clients['status'] != 'SUCCESS') {
            Yii::error('Ошибка при получении постоянныйх клинетов', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при получении постоянныйх клинетов',
            ];
        }

        $pastDueEquipments = ReportClass::GetPastDueEquipments();
        if (!is_array($pastDueEquipments) || !isset($pastDueEquipments['status']) || $pastDueEquipments['status'] != 'SUCCESS') {
            Yii::error('Ошибка при получении просроченных оборудований', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при получении списка просроченных оборудований',
            ];
        }

        Yii::info('Список оборудования успешно получен', __METHOD__);

        $result['data'] = [
            $newClients['data'], $clients['data'], $pastDueEquipments['data']
        ];

        return [
            'status' => 'OK',
            'msg' => 'Список виджетов успешно получен',
            'data' => $result['data']
        ];
    }
}