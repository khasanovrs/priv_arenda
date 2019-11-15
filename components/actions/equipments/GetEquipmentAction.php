<?php
/**
 * Получение списка оборудования
 */

namespace app\components\actions\equipments;

use app\components\equipments\EquipmentsClass;
use Yii;
use yii\base\Action;

class GetEquipmentAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции получения списка оборудования', __METHOD__);

        $request = Yii::$app->request;

        $status = $request->getBodyParam('status');
        $like = $request->getBodyParam('like');
        $stock = $request->getBodyParam('stock');
        $equipmentsType = $request->getBodyParam('equipmentsType');
        $equipmentsCategory = $request->getBodyParam('equipmentsCategory');
        $count_start = $request->getBodyParam('count_start');
        $count_end = $request->getBodyParam('count_end');
        $selling_price_start = $request->getBodyParam('selling_price_start');
        $selling_price_end = $request->getBodyParam('selling_price_end');
        $price_per_day_start = $request->getBodyParam('price_per_day_start');
        $price_per_day_end = $request->getBodyParam('price_per_day_end');
        $rentals_start = $request->getBodyParam('rentals_start');
        $rentals_end = $request->getBodyParam('rentals_end');
        $repairs_start = $request->getBodyParam('repairs_start');
        $repairs_end = $request->getBodyParam('repairs_end');
        $repairs_sum_start = $request->getBodyParam('repairs_sum_start');
        $repairs_sum_end = $request->getBodyParam('repairs_sum_end');
        $revenue_start = $request->getBodyParam('revenue_start');
        $revenue_end = $request->getBodyParam('revenue_end');
        $profit_start = $request->getBodyParam('profit_start');
        $profit_end = $request->getBodyParam('profit_end');
        $degree_wear_start = $request->getBodyParam('degree_wear_start');
        $degree_wear_end = $request->getBodyParam('degree_wear_end');
        $confirmed = $request->getBodyParam('confirmed');
        $lesa = $request->getBodyParam('lesa');

        $result = EquipmentsClass::GetEquipments($status, $like, $stock, $equipmentsType, $equipmentsCategory, $count_start, $count_end, $selling_price_start, $selling_price_end, $price_per_day_start, $price_per_day_end, $rentals_start, $rentals_end, $repairs_start, $repairs_end, $repairs_sum_start, $repairs_sum_end, $revenue_start, $revenue_end, $profit_start, $profit_end, $degree_wear_start, $degree_wear_end, $confirmed,$lesa);

        if (!is_array($result) || !isset($result['status']) || $result['status'] != 'SUCCESS') {
            Yii::error('Ошибка при получении списка оборудования', __METHOD__);

            if (is_array($result) && isset($result['status']) && $result['status'] === 'ERROR') {
                return $result;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при получении списка оборудования',
            ];
        }

        Yii::info('Список оборудования успешно получен', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Список оборудований успешно получен',
            'data' => $result['data']
        ];
    }
}