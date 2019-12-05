<?php
/**
 * Сохранение информации об оборудовании
 */

namespace app\components\actions\equipments;

use app\components\equipments\EquipmentsClass;
use Yii;
use yii\base\Action;

class SaveEquipmentDemandInfoAction extends Action
{
    public function run()
    {
        Yii::info('Запуск информации об оборудовании', __METHOD__);

        $request = Yii::$app->request;

        $id = $request->getBodyParam('id');
        $name = $request->getBodyParam('name');

        $result = EquipmentsClass::saveEquipmentsInfoDemand($id, $name);

        if (!is_array($result) || !isset($result['status']) || $result['status'] != 'SUCCESS') {
            Yii::error('Ошибка при сохранении информации об оборудовании', __METHOD__);

            if (is_array($result) && isset($result['status']) && $result['status'] === 'ERROR') {
                return $result;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при сохранении информации об оборудовании',
            ];
        }

        Yii::info('Информация об оборудовании сохранена', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Информация об оборудовании сохранено'
        ];
    }
}