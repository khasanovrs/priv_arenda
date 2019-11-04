<?php
/**
 * добавление нового оборудования
 */

namespace app\components\actions\equipments;

use app\components\equipments\EquipmentsClass;
use Yii;
use yii\base\Action;

class AddEquipmentMiniAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции добавления нового оборудования для спроса', __METHOD__);

        $request = Yii::$app->request;

        $model = $request->getBodyParam('model');
        $mark = $request->getBodyParam('mark');
        $stock = $request->getBodyParam('stock');
        $equipmentsType = $request->getBodyParam('equipmentsType');
        $equipmentsCategory = $request->getBodyParam('equipmentsCategory');

        $result = EquipmentsClass::AddEquipment($model, $mark, 7, $stock, $equipmentsType, $equipmentsCategory, '', 0, 0, '', '', 1, '', '', '', '', '', '', '', '', '', '', '', '', '',0, 1);

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