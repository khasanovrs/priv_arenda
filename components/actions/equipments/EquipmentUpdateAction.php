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
        $status = $request->getBodyParam('status');
        $model = $request->getBodyParam('model');
        $mark = $request->getBodyParam('mark');
        $stock = $request->getBodyParam('stock');
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
        $repairs = $request->getBodyParam('repairs');
        $repairs_sum = $request->getBodyParam('repairs_sum');
        $profit = $request->getBodyParam('profit');
        $payback_ratio = $request->getBodyParam('payback_ratio');
        $power_energy = $request->getBodyParam('power_energy');
        $length = $request->getBodyParam('length');
        $network_cord = $request->getBodyParam('network_cord');
        $power = $request->getBodyParam('power');
        $frequency_hits = $request->getBodyParam('frequency_hits');

        $result = EquipmentsClass::changeEquipment($id, $model, $mark, $status, $stock, $equipmentsType, $equipmentsCategory, $count, $tool_number, $selling_price, $price_per_day, $revenue, $degree_wear, $discount, $rentals, $repairs, $repairs_sum, $profit, $payback_ratio, $power_energy, $length, $network_cord, $power, $frequency_hits);

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