<?php
/**
 * Добавление клиента юр.лица
 */

namespace app\components\actions\client;

use app\components\Clients\ClientsClass;
use Yii;
use yii\base\Action;

class AddUrClientAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции добавления юр.клиента', __METHOD__);

        $request = Yii::$app->request;

        $name_org = $request->getBodyParam('name_org');
        $phone = $request->getBodyParam('phone');
        $status = $request->getBodyParam('status');
        $last_contact = $request->getBodyParam('last_contact');
        $source = $request->getBodyParam('source');
        $rentals = $request->getBodyParam('rentals');
        $dohod = $request->getBodyParam('dohod');
        $sale = $request->getBodyParam('sale');

        $resultChange = ClientsClass::AddClientUr($name_org, $phone, $status, $last_contact, $source, $rentals, $dohod, $sale);

        if (!is_array($resultChange) || !isset($resultChange['status']) || $resultChange['status'] != 'SUCCESS') {
            Yii::error('Ошибка при добавлении нового пользователя', __METHOD__);

            if (is_array($resultChange) && isset($resultChange['status']) && $resultChange['status'] === 'SUCCESS') {
                return $resultChange;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при добавлении нового пользователя',
            ];
        }

        Yii::info('Клиент успешно добавлен', __METHOD__);

        return [
            'status' => 'ОК',
            'msg' => 'Клиент успешно добавлен',
        ];
    }
}