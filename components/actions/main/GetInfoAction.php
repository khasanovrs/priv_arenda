<?php
/**
 * Получение информации для рабочего стола
 */

namespace app\components\actions\main;

use app\components\main\MainClass;
use Yii;
use yii\base\Action;

class GetInfoAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции получения информации для рабочего стола', __METHOD__);

        $request = Yii::$app->request;

        $branch = $request->getBodyParam('branch');

        $result_income = MainClass::getIncome($branch);

        if (!is_array($result_income) || !isset($result_income['status']) || $result_income['status'] != 'SUCCESS') {
            Yii::error('Ошибка при получении информации для рабочего стола', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при получении информации для рабочего стола',
            ];
        }

        Yii::info('Информация для рабочего стола успешно получена', __METHOD__);

        $result['data'] = [
            'income' => $result_income['data']
        ];

        return [
            'status' => 'OK',
            'msg' => 'Информация для рабочего стола успешно получена',
            'data' => $result['data']
        ];
    }
}