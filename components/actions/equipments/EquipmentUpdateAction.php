<?php
/**
 * изменение оборудования
 */

namespace app\components\actions\equipments;

use app\components\equipments\EquipmentsClass;
use Yii;
use yii\base\Action;

class EquipmentUpdateAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции изменения оборудования', __METHOD__);

        $request = Yii::$app->request;

        $id = $request->getBodyParam('id');
        $model = $request->getBodyParam('model');
        $mark = $request->getBodyParam('mark');
        $new_stock = $request->getBodyParam('new_stock');
        $old_stock = $request->getBodyParam('old_stock');
        $reason_change_stock = $request->getBodyParam('reason_change_stock');
        $equipmentsType = $request->getBodyParam('equipmentsType');
        $equipmentsCategory = $request->getBodyParam('equipmentsCategory');
        $count = $request->getBodyParam('count');
        $tool_number = $request->getBodyParam('tool_number');
        $selling_price = $request->getBodyParam('selling_price');
        $price_per_day = $request->getBodyParam('price_per_day');
        $revenue = $request->getBodyParam('revenue');
        $degree_wear = $request->getBodyParam('degree_wear');
        $discount = $request->getBodyParam('discount');
        $rentals = $request->getBodyParam('rentals');
        $profit = $request->getBodyParam('profit');
        $payback_ratio = $request->getBodyParam('payback_ratio');
        $power_energy = $request->getBodyParam('power_energy');
        $length = $request->getBodyParam('length');
        $network_cord = $request->getBodyParam('network_cord');
        $power = $request->getBodyParam('power');
        $frequency_hits = $request->getBodyParam('frequency_hits');
        $photo_alias = $request->getBodyParam('photo_alias');
        $new_status = $request->getBodyParam('new_status');
        $old_status = $request->getBodyParam('old_status');
        $reason_change_status = $request->getBodyParam('reason_change_status');
        $amount_repair = $request->getBodyParam('amount_repair');
        $cash_box = $request->getBodyParam('cash_box');
        $sale_amount = $request->getBodyParam('sale_amount');
        $confirmed = $request->getBodyParam('confirmed');

        $result = EquipmentsClass::changeEquipment($id, $model, $mark, $new_stock, $old_stock, $reason_change_stock, $equipmentsType, $equipmentsCategory, $count, $tool_number, $selling_price, $price_per_day, $revenue, $degree_wear, $discount, $rentals, $profit, $payback_ratio, $power_energy, $length, $network_cord, $power, $frequency_hits, $photo_alias, $new_status, $old_status, $reason_change_status, $amount_repair, $cash_box, $sale_amount, $confirmed);

        if (!is_array($result) || !isset($result['status']) || $result['status'] != 'SUCCESS') {
            Yii::error('Ошибка при изменении оборудования', __METHOD__);

            if (is_array($result) && isset($result['status']) && $result['status'] === 'ERROR') {
                return $result;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при изменении оборудования',
            ];
        }

        Yii::info('Оборудование успешно изменено', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Оборудование успешно изменено'
        ];
    }
}