<?php
/**
 * Получение информации по прокату
 */

namespace app\components\actions\hire;

use app\components\hire\PayClass;
use Yii;
use yii\base\Action;

class GetHireInfoAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции получения проката', __METHOD__);

        $request = Yii::$app->request;

        $id = $request->getBodyParam('id');

        $result = PayClass::getHireInfo($id);

        if (!is_array($result) || !isset($result['status']) || $result['status'] != 'SUCCESS') {
            Yii::error('Ошибка при получении информации по прокату', __METHOD__);

            if (is_array($result) && isset($result['status']) && $result['status'] === 'ERROR') {
                return $result;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при получении информации по прокату',
            ];
        }

        Yii::info('Информация по прокату успешно получена', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Информация по прокату успешно получена',
            'data' => $result['data']
        ];
    }
}