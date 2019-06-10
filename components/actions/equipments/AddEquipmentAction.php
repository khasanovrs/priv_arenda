<?php
/**
 * добавление нового оборудования
 */

namespace app\components\actions\equipments;

use app\components\equipments\EquipmentsClass;
use Yii;
use yii\base\Action;

class AddEquipmentAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции добавления нового оборудования', __METHOD__);

        $request = Yii::$app->request;

        $status = $request->getBodyParam('status');
        $name = $request->getBodyParam('name');
        $stock = $request->getBodyParam('stock');
        $equipmentsType = $request->getBodyParam('equipmentsType');
        $equipmentsCategory = $request->getBodyParam('equipmentsCategory');
        $count = $request->getBodyParam('count');
        $tool_number = $request->getBodyParam('tool_number');
        $selling_price = $request->getBodyParam('selling_price');
        $price_per_day = $request->getBodyParam('price_per_day');
        $revenue = $request->getBodyParam('revenue');
        $degree_wear = $request->getBodyParam('degree_wear');
        $sale = $request->getBodyParam('sale');
        $impact_energy = $request->getBodyParam('impact_energy');
        $length = $request->getBodyParam('length');
        $network_cord = $request->getBodyParam('network_cord');
        $power = $request->getBodyParam('power');
        $frequency_hits = $request->getBodyParam('frequency_hits');

        $result = EquipmentsClass::AddEquipmentFields($name, $status, $stock, $equipmentsType, $equipmentsCategory, $count, $tool_number, $selling_price, $price_per_day, $revenue, $degree_wear, $sale, $impact_energy, $length, $network_cord, $power, $frequency_hits);

        if (!is_array($result) || !isset($result['status']) || $result['status'] != 'SUCCESS') {
            Yii::error('Ошибка при добавлении оборудования', __METHOD__);

            if (is_array($result) && isset($result['status']) && $result['status'] === 'ERROR') {
                return $result;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при добавлении оборудования',
            ];
        }

        Yii::info('Оборудование успешно добавлено', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Оборудование успешно добавлено'
        ];
    }
}