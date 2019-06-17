<?php
/**
 * Получение списка оборудования по фильтру
 */

namespace app\components\actions\equipments;

use app\components\equipments\EquipmentsClass;
use Yii;
use yii\base\Action;

class GetEquipmentSearchAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции получения списка оборудования по фильтру', __METHOD__);

        $request = Yii::$app->request;

        $filter = $request->getBodyParam('filter');

        $result = EquipmentsClass::GetEquipmentsSearch($filter);

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