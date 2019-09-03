<?php
/**
 * Добавление клиента
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

        $sale = $request->getBodyParam('sale');
        $branch = $request->getBodyParam('branch');
        $status = $request->getBodyParam('status');
        $source = $request->getBodyParam('source');
        $inn = $request->getBodyParam('inn');
        $kpp = $request->getBodyParam('kpp');
        $name_chief = $request->getBodyParam('name_chief');
        $fio = $request->getBodyParam('fio');
        $phone_1 = $request->getBodyParam('phone_1');
        $phone_2 = $request->getBodyParam('phone_2');
        $phone_3 = $request->getBodyParam('phone_3');
        $email = $request->getBodyParam('email');
        $number_passport = $request->getBodyParam('number_passport');

        $resultChange = ClientsClass::AddClient($sale, $branch, $status, $source, $inn, $kpp, $name_chief, $fio, $phone_1, $phone_2, $phone_3, $email, $number_passport);

        if (!is_array($resultChange) || !isset($resultChange['status']) || $resultChange['status'] != 'SUCCESS') {
            Yii::error('Ошибка при добавлении нового клиента', __METHOD__);

            if (is_array($resultChange) && isset($resultChange['status']) && $resultChange['status'] === 'ERROR') {
                return $resultChange;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при добавлении нового клинета',
            ];
        }

        Yii::info('Клиент успешно добавлен', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Клиент успешно добавлен',
        ];
    }
}