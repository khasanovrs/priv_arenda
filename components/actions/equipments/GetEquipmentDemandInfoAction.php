<?php
/**
 * Получение оборудования
 */

namespace app\components\actions\equipments;

use app\components\equipments\EquipmentsClass;
use Yii;
use yii\base\Action;

class GetEquipmentDemandInfoAction extends Action
{
    public function run()
    {
        Yii::info('Запуск информации об оборудовании', __METHOD__);

        $request = Yii::$app->request;

        $id = $request->getBodyParam('id');

        $result = EquipmentsClass::GetEquipmentsInfoDemand($id);

        if (!is_array($result) || !isset($result['status']) || $result['status'] != 'SUCCESS') {
            Yii::error('Ошибка при получении информации об оборудовании', __METHOD__);

            if (is_array($result) && isset($result['status']) && $result['status'] === 'ERROR') {
                return $result;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при получении информации об оборудовании',
            ];
        }

        Yii::info('Информация об оборудовании получено', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Список оборудований успешно получен',
            'data' => $result['data']
        ];
    }
}