<?php
/**
 * Получение списка прокатов
 */

namespace app\components\actions\hire;

use app\components\hire\HireClass;
use Yii;
use yii\base\Action;

class GetHireAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции получения списка заявок', __METHOD__);

        $request = Yii::$app->request;

        $status = $request->getBodyParam('status');
        $like = $request->getBodyParam('like');
        $branch = $request->getBodyParam('branch');
        $date_start = $request->getBodyParam('date_start');
        $date_end = $request->getBodyParam('date_end');
        $show_close_hire = $request->getBodyParam('show_close_hire');

        $result = HireClass::getHire($status, $like, $branch, $date_start, $date_end, $show_close_hire);

        if (!is_array($result) || !isset($result['status']) || $result['status'] != 'SUCCESS') {
            Yii::error('Ошибка при получении списка прокатов', __METHOD__);

            if (is_array($result) && isset($result['status']) && $result['status'] === 'ERROR') {
                return $result;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при получении списка прокатов',
            ];
        }

        Yii::info('Список прокатов успешно получен', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Заявки успешно получены',
            'data' => $result['data']
        ];
    }
}