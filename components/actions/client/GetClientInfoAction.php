<?php
/**
 * Получение детальной информации по клиенту
 */

namespace app\components\actions\client;

use app\components\Clients\ClientsClass;
use Yii;
use yii\base\Action;

class GetClientInfoAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции получения детальной информации по клиенту', __METHOD__);

        $request = Yii::$app->request;

        $clientId = $request->getBodyParam('clientId');
        $clientType = $request->getBodyParam('clientType');

        $result = ClientsClass::GetDetailInfoClient($clientId, $clientType);

        if (!is_array($result) || !isset($result['status']) || $result['status'] != 'SUCCESS') {
            Yii::error('Ошибка при получении детальной информации по клиенту', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при получении детальной информации по клиенту',
            ];
        }

        Yii::info('Информация по клиенту успешно получена', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Информация по клиенту успешно получена',
            'data' => $result['data']
        ];
    }
}