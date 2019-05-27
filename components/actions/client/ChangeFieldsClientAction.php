<?php
/**
 * Изменение списка отображаемых полей для таблицы "клиенты"
 */

namespace app\components\actions\client;

use app\components\Clients\ClientsClass;
use Yii;
use yii\base\Action;

class ChangeFieldsClientAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции изменения списка отображаемых полей для таблицы "клиенты"', __METHOD__);

        $request = Yii::$app->request;

        $name_org = $request->getBodyParam('name_org');

        $result = ClientsClass::ChangeFields($name_org);

        if (!is_array($result) || !isset($result['status']) || $result['status'] != 'SUCCESS') {
            Yii::error('Ошибка при изменении списка отображаемых полей для таблицы "клиенты"', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при изменении списка отображаемых полей для таблицы "клиенты"',
            ];
        }

        Yii::info('Список полей успешно изменен', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Список полей успешно изменен',
            'data' => $result['data']
        ];
    }
}