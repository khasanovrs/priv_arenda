<?php
/**
 * Получение списка юр.клиентов
 */

namespace app\components\actions\client;

use app\components\Clients\ClientsClass;
use Yii;
use yii\base\Action;

class GetUrClientAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции получения списка клиентов', __METHOD__);

        $request = Yii::$app->request;

        $type = $request->getBodyParam('type');
        $like = $request->getBodyParam('like');

        $resultChange = ClientsClass::GetClient($type, $like);

        if (!is_array($resultChange) || !isset($resultChange['status']) || $resultChange['status'] != 'SUCCESS') {
            Yii::error('Ошибка при получении клиентов', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при получении списка клиентов',
            ];
        }

        Yii::info('Список клиентов успешно получен', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Список клиентов успешно получен',
            'data' => $resultChange['data']
        ];
    }
}