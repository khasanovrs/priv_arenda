<?php
/**
 * Уменьшение срока проката
 */

namespace app\components\actions\hire;

use app\components\hire\HireClass;
use Yii;
use yii\base\Action;

class TameRentalAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции уменьшения проката', __METHOD__);

        $request = Yii::$app->request;

        $app_id = $request->getBodyParam('app_id');
        $app_eq_id = $request->getBodyParam('app_eq_id');
        $count = $request->getBodyParam('count');

        $result = HireClass::TameRental($app_eq_id, $app_id, $count);

        if (!is_array($result) || !isset($result['status']) || $result['status'] != 'SUCCESS') {
            Yii::error('Ошибка при уменьшении проката', __METHOD__);

            if (is_array($result) && isset($result['status']) && $result['status'] === 'ERROR') {
                return $result;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при уменьшении проката',
            ];
        }

        Yii::info('Прокат успешно обновлен', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Прокат успешно обновлен'
        ];
    }
}