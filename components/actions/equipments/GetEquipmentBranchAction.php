<?php
/**
 * Получение списка популярных оборудований
 */

namespace app\components\actions\equipments;

use app\components\equipments\EquipmentsClass;
use Yii;
use yii\base\Action;

class GetEquipmentBranchAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции получения списка популярных оборудований', __METHOD__);

        $request = Yii::$app->request;

        $branch = $request->getBodyParam('branch');

        $result = EquipmentsClass::GetEquipmentsBranch($branch);

        if (!is_array($result) || !isset($result['status']) || $result['status'] != 'SUCCESS') {
            Yii::error('Ошибка при получении списка популярных оборудований', __METHOD__);

            if (is_array($result) && isset($result['status']) && $result['status'] === 'ERROR') {
                return $result;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при получении списка популярных оборудований',
            ];
        }

        Yii::info('Список популярных оборудований успешно получен', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Список популярных оборудований успешно получен',
            'data' => $result['data']
        ];
    }
}