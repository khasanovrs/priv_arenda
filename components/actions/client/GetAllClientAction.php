<?php
/**
 * Получение списка клиентов
 */

namespace app\components\actions\client;

use app\components\Clients\ClientsClass;
use Yii;
use yii\base\Action;

class GetAllClientAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции получения списка клиенту', __METHOD__);

        $request = Yii::$app->request;

        $filter = $request->getBodyParam('filter');

        $result = ClientsClass::GetAllClient();

        if (!is_array($result) || !isset($result['status']) || $result['status'] != 'SUCCESS') {
            Yii::error('Ошибка при получении списка клиентов', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при получении списка клиентов',
            ];
        }

        Yii::info('Список клиентов спешно получен', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Список клиентов спешно получен',
            'data' => $result['data']
        ];
    }
}