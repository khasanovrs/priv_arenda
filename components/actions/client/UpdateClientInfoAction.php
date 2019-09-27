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
        $new_status = $request->getBodyParam('new_status');
        $old_status = $request->getBodyParam('old_status');
        $reason_change_status = $request->getBodyParam('reason_change_status');
        $source = $request->getBodyParam('source');
        $inn = $request->getBodyParam('inn');
        $kpp = $request->getBodyParam('kpp');
        $name_chief = $request->getBodyParam('name_chief');
        $name = $request->getBodyParam('name');
        $fio = $request->getBodyParam('fio');
        $phone_1 = $request->getBodyParam('phone_1');
        $phone_2 = $request->getBodyParam('phone_2');
        $phone_3 = $request->getBodyParam('phone_3');
        $email = $request->getBodyParam('email');
        $number_passport = $request->getBodyParam('number_passport');

        $resultChange = ClientsClass::UpdateClientInfo($clientId, $sale, $branch, $new_status,$old_status,$reason_change_status, $source, $inn, $kpp, $name_chief, $fio, $phone_1, $phone_2, $phone_3, $email, $number_passport,$name);

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