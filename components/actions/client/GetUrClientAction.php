<?php
/**
 * Редактирование клиента юр.лица
 */

namespace app\components\actions\client;

use app\components\Clients\ClientsClass;
use Yii;
use yii\base\Action;

class ChangeUrClientAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции изменения параметров юр.клиента', __METHOD__);

        $request = Yii::$app->request;

        $name_org = $request->getBodyParam('name_org');
        $phone = $request->getBodyParam('phone');
        $status = $request->getBodyParam('status');
        $last_contact = $request->getBodyParam('last_contact');
        $source = $request->getBodyParam('source');
        $rentals = $request->getBodyParam('rentals');
        $dohod = $request->getBodyParam('dohod');
        $sale = $request->getBodyParam('sale');
        $id = $request->getBodyParam('id');

        $resultChange = ClientsClass::ChangeClientUr($id, $name_org, $phone, $status, $last_contact, $source, $rentals, $dohod, $sale);

        if (!is_array($resultChange) || !isset($resultChange['status']) || $resultChange['status'] != 'SUCCESS') {
            Yii::error('Ошибка при изменения параметров юр.клиента', __METHOD__);

            if (is_array($resultChange) && isset($resultChange['status']) && $resultChange['status'] === 'ERROR') {
                return $resultChange;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при изменения параметров юр.клиента',
            ];
        }

        Yii::info('Параметры успешно изменены', __METHOD__);

        return [
            'status' => 'ОК',
            'msg' => 'Параметры успешно изменены',
        ];
    }
}