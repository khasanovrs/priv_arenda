<?php
/**
 * Удаление клиента
 */

namespace app\components\actions\client;

use app\components\Clients\ClientsClass;
use Yii;
use yii\base\Action;

class DeleteClientAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции удаления клиента', __METHOD__);

        $request = Yii::$app->request;

        $id = $request->getBodyParam('id');

        $result = ClientsClass::DeleteClient($id);

        if (!is_array($result) || !isset($result['status']) || $result['status'] != 'SUCCESS') {
            Yii::error('Ошибка при удалении клиента', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при удалении клиента',
            ];
        }

        Yii::info('Клиент успешно удален', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Клиент успешно удален',
        ];
    }
}