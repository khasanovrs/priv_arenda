<?php
/**
 * Получение информации для шапки
 */

namespace app\components\actions\main;

use app\components\main\MainClass;
use Yii;
use yii\base\Action;

class GetRevenueAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции получения информации для шапки', __METHOD__);

        $request = Yii::$app->request;

        $branch = $request->getBodyParam('branch');

        $result = MainClass::getRevenue($branch);

        if (!is_array($result) || !isset($result['status']) || $result['status'] != 'SUCCESS') {
            Yii::error('Ошибка при получении информации для шапки', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при получении информации для шапки',
            ];
        }

        Yii::info('Информация для шапки успешно получена', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Информация для шапки успешно получена',
            'data' => $result['data']
        ];
    }
}