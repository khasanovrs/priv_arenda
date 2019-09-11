<?php
/**
 * Получение информации для рабочего стола
 */

namespace app\components\actions\main;

use app\components\equipments\EquipmentsClass;
use app\components\main\MainClass;
use Yii;
use yii\base\Action;

class GetInfoAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции получения информации для рабочего стола', __METHOD__);

        $request = Yii::$app->request;

        $branch = $request->getBodyParam('branch');
        $date_start = $request->getBodyParam('date_start');
        $date_end = $request->getBodyParam('date_end');

        $result_income = MainClass::getIncome($branch, $date_start, $date_end);

        if (!is_array($result_income) || !isset($result_income['status']) || $result_income['status'] != 'SUCCESS') {
            Yii::error('Ошибка при получении информации для рабочего стола', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при получении информации для рабочего стола',
            ];
        }

        $eqResult = EquipmentsClass::GetEquipmentsBranch($branch, $date_start, $date_end);

        if (!is_array($eqResult) || !isset($eqResult['status']) || $eqResult['status'] != 'SUCCESS') {
            Yii::error('Ошибка при получении списка популярных оборудований', __METHOD__);

            if (is_array($eqResult) && isset($eqResult['status']) && $eqResult['status'] === 'ERROR') {
                return $eqResult;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при получении списка популярных оборудований',
            ];
        }

        Yii::info('Информация для рабочего стола успешно получена', __METHOD__);

        $result['data'] = [
            'income' => [],
            'equipments' => $eqResult['data']
        ];

        return [
            'status' => 'OK',
            'msg' => 'Информация для рабочего стола успешно получена',
            'data' => $result['data']
        ];
    }
}