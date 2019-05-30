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
        $name = $request->getBodyParam('name');
        $inn = $request->getBodyParam('inn');
        $occupation = $request->getBodyParam('occupation');
        $address = $request->getBodyParam('address');
        $ogrn = $request->getBodyParam('ogrn');
        $bic = $request->getBodyParam('bic');
        $kpp = $request->getBodyParam('kpp');
        $schet = $request->getBodyParam('schet');
        $name_chief = $request->getBodyParam('name_chief');
        $phone_chief = $request->getBodyParam('phone_chief');
        $phone = $request->getBodyParam('phone');
        $phone_2 = $request->getBodyParam('phone_2');
        $email = $request->getBodyParam('email');

        $resultChange = ClientsClass::AddClient($sale, $branch, $status, $source, $name, $inn, $occupation, $address, $ogrn, $bic, $kpp, $schet, $name_chief, $phone_chief, $phone, $phone_2, $email);

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