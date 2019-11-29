<?php
/**
 * Получение списка оборудования для спроса
 */

namespace app\components\actions\equipments;

use app\components\equipments\EquipmentsClass;
use Yii;
use yii\base\Action;

class GetEquipmentDemandAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции получения списка оборудования', __METHOD__);

        $request = Yii::$app->request;

        $like = $request->getBodyParam('like');
        $stock = $request->getBodyParam('stock');
        $type = $request->getBodyParam('type');

        $result = EquipmentsClass::GetEquipmentsDemand($like, $stock, $type);

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