<?php
/**
 * Получение списка прокатов
 */

namespace app\components\actions\hire;

use app\components\hire\HireClass;
use Yii;
use yii\base\Action;

class ExtendRentalAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции получения списка заявок', __METHOD__);

        $request = Yii::$app->request;

        $app_id = $request->getBodyParam('app_id');
        $count = $request->getBodyParam('count');

        $result = HireClass::ExtendRental($app_id, $count);

        if (!is_array($result) || !isset($result['status']) || $result['status'] != 'SUCCESS') {
            Yii::error('Ошибка при продлении контракта', __METHOD__);

            if (is_array($result) && isset($result['status']) && $result['status'] === 'ERROR') {
                return $result;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при продлении контракта',
            ];
        }

        Yii::info('Прокат успешно обновлен', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Прокат успешно обновлен'
        ];
    }
}