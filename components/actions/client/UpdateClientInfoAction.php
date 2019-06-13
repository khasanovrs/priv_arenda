<?php
/**
 * Обновление детальной  информации клиента
 */

namespace app\components\actions\client;

use app\components\Clients\ClientsClass;
use Yii;
use yii\base\Action;

class UpdateClientInfoAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции изменения детальнной информации клиента', __METHOD__);

        $request = Yii::$app->request;

        $clientId = $request->getBodyParam('clientId');
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

        $resultChange = ClientsClass::UpdateClientInfo($clientId, $sale, $branch, $status, $source, $name, $inn, $occupation, $address, $ogrn, $bic, $kpp, $schet, $name_chief, $phone_chief, $phone, $phone_2, $email);

        if (!is_array($resultChange) || !isset($resultChange['status']) || $resultChange['status'] != 'SUCCESS') {
            Yii::error('Ошибка при изменения детальнной информации клиента', __METHOD__);

            if (is_array($resultChange) && isset($resultChange['status']) && $resultChange['status'] === 'ERROR') {
                return $resultChange;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при изменения детальнной информации клиента',
            ];
        }

        Yii::info('Информаций успешно изменена', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Пользователь успешно изменен',

        ];
    }
}