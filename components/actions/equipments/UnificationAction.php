<?php
/**
 * объединение оборудований для спроса
 */

namespace app\components\actions\equipments;

use app\components\equipments\EquipmentsClass;
use Yii;
use yii\base\Action;

class UnificationAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции объединения оборудовании', __METHOD__);

        $request = Yii::$app->request;

        $unification = $request->getBodyParam('unification');
        $new_name = $request->getBodyParam('new_name');

        $result = EquipmentsClass::unification($unification, $new_name);

        if (!is_array($result) || !isset($result['status']) || $result['status'] != 'SUCCESS') {
            Yii::error('Ошибка при объединении оборудований', __METHOD__);

            if (is_array($result) && isset($result['status']) && $result['status'] === 'ERROR') {
                return $result;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при объединении оборудований',
            ];
        }

        Yii::info('Оборудования успешно объединены', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Оборудования успешно объединены'
        ];
    }
}