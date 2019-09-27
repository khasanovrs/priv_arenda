<?php
/**
 * Редактирование статуса юр.лица
 */

namespace app\components\actions\client;

use app\components\Clients\ClientsClass;
use Yii;
use yii\base\Action;

class UpdateStatusUrClientAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции изменения статус юр.клиента', __METHOD__);

        $request = Yii::$app->request;

        $client_id = $request->getBodyParam('client_id');
        $old_status = $request->getBodyParam('old_status');
        $new_status = $request->getBodyParam('new_status');
        $text = $request->getBodyParam('text');

        $resultChange = ClientsClass::UpdateStatusClientUr($client_id, $old_status, $new_status, $text);

        if (!is_array($resultChange) || !isset($resultChange['status']) || $resultChange['status'] != 'SUCCESS') {
            Yii::error('Ошибка при изменения статуса юр.клиента', __METHOD__);

            if (is_array($resultChange) && isset($resultChange['status']) && $resultChange['status'] === 'ERROR') {
                return $resultChange;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при изменения статуса клиента',
            ];
        }

        Yii::info('Статус успешно изменен', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Статус успешно изменен',

        ];
    }
}