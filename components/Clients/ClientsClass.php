<?php
/**
 * Управление клиентами
 */

namespace app\components\Clients;

use app\components\Session\Sessions;
use app\models\ApplicationPay;
use app\models\Applications;
use app\models\Branch;
use app\models\ClientField;
use app\models\ClientFiz;
use app\models\ClientFizInfo;
use app\models\Clients;
use app\models\ClientShowField;
use app\models\ClientsInfo;
use app\models\ClientSource;
use app\models\ClientStatus;
use app\models\ClientStatusChange;
use app\models\ClientUr;
use app\models\ClientUrInfo;
use app\models\Discount;
use app\models\Settings;
use app\models\ShowFieldClient;
use app\models\Source;
use Codeception\Application;
use Yii;

class ClientsClass
{
    /**
     * Добавление нового клиента
     * @param $clientId
     * @param $name
     * @param $sale
     * @param $branch
     * @param $new_status
     * @param $old_status
     * @param $reason_change_status
     * @param $source
     * @param $inn
     * @param $kpp
     * @param $name_chief
     * @param $fio
     * @param $phone_1
     * @param $phone_2
     * @param $phone_3
     * @param $email
     * @param $number_passport
     * @param $date_birth
     * @param $type
     * @return array|bool
     * @throws \yii\base\InvalidConfigException
     */
    public static function AddClient($clientId, $name, $sale, $branch, $new_status, $old_status, $reason_change_status, $source, $inn, $kpp, $name_chief, $fio, $phone_1, $phone_2, $phone_3, $email, $number_passport, $date_birth, $type = '')
    {
        Yii::info('Запуск функции добавления клиента', __METHOD__);

        if ($sale === '') {
            Yii::error('Не передано значение скидки, sale: ' . serialize($sale), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не передано значение скидки',
            ];
        }

        if ($branch === '') {
            Yii::error('Не передан идентификатор филиала, branch: ' . serialize($branch), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не передан идентификатор филиала'
            ];
        }

        if ($source === '') {
            Yii::error('Не передан идентификатор источника, source: ' . serialize($source), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не передан идентификатор источника',
            ];
        }

        if ($phone_1 === '') {
            Yii::error('Не передан номер телефона', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не передан номер телефона',
            ];
        } else if (($phone_1 !== '' && strlen($phone_1) !== 11) || ($phone_2 !== '' && strlen($phone_2) !== 11) || ($phone_3 !== '' && strlen($phone_3) !== 11)) {
            Yii::error('Указан некорректный номер телефона', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Указан некорректный номер телефона',
            ];
        }

        if ($email != '' && !preg_match("/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i", $email)) {
            Yii::error('Передан некорректный email, email:' . serialize($email), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Передан некорректный email',
            ];
        }

        $check_branch = Branch::find()->where('id=:id', [':id' => $branch])->one();

        if (!is_object($check_branch)) {
            Yii::error('Передан некорректный идентификатор филиала, branch:' . serialize($branch), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Передан некорректный идентификатор филиала',
            ];
        }

        $check_discount = Discount::find()->where('id=:id', [':id' => $sale])->one();

        if (!is_object($check_discount)) {
            Yii::error('Передан некорректный идентификатор скидки, sale:' . serialize($sale), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Передан некорректный идентификатор скидки',
            ];
        }

        $check_source = Source::find()->where('id=:id', [':id' => $source])->one();

        if (!is_object($check_source)) {
            Yii::error('Передан некорректный исчтоник, :' . serialize($source), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Передан некорректный исчтоник',
            ];
        }

        Yii::info('Добавляем нового клиента', __METHOD__);

        /**
         * @var Clients $check_phone
         */
        $check_phone = Clients::find()->where('phone=:phone and type!=3', [':phone' => $phone_1])->one();

        if (is_object($check_phone) && $clientId != $check_phone->id) {
            Yii::error('Клиент с данным номер телефона уже зарегестрирован, phone:' . serialize($phone_1), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Клиент с данным номер телефона уже зарегестрирован',
            ];
        }

        if ($clientId === '') {
            Yii::info('Создание нового клиента', __METHOD__);

            if ($new_status === '') {
                Yii::error('Не передан идентификатор статуса, status: ' . serialize($new_status), __METHOD__);

                return [
                    'status' => 'ERROR',
                    'msg' => 'Не передан идентификатор статуса',
                ];
            }


            $check_status = ClientStatus::find()->where('id=:id', [':id' => $new_status])->one();

            if (!is_object($check_status)) {
                Yii::error('Передан некорректный статус, status:' . serialize($new_status), __METHOD__);

                return [
                    'status' => 'ERROR',
                    'msg' => 'Передан некорректный статус',
                ];
            }

            $newClient = new Clients();

            $newClient->status = $new_status;

            $newClientInfo = new ClientsInfo();
        } else {
            Yii::info('Обновление информациии о клиенте', __METHOD__);

            /**
             * @var Clients $newClient
             */
            $newClient = Clients::find()->where('id=:id', [':id' => $clientId])->one();

            if (!is_object($newClient)) {
                Yii::error('Клиент не найден, id:' . serialize($newClient), __METHOD__);

                return [
                    'status' => 'ERROR',
                    'msg' => 'Клиент не найден',
                ];
            }

            if ($new_status !== $old_status) {
                $resultChange = self::UpdateStatusClientUr($clientId, $old_status, $new_status, $reason_change_status);

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
            }

            $newClientInfo = $newClient->clientsInfos[0];
        }

        $newClient->name = $fio === '' ? $name : $fio;
        $newClient->type = $type !== '' ? $type : ($fio === '' ? 2 : 1);
        $newClient->phone = $phone_1;
        $newClient->branch_id = $branch;
        $newClient->last_contact = date('Y-m-d H:i:s');
        $newClient->date_create = date('Y-m-d H:i:s');

        try {
            if (!$newClient->save(false)) {
                Yii::error('Ошибка при добавлении клиента: ' . serialize($newClient->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при добавлении клиента: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        /**
         * @var Clients $client
         */
        $client = Clients::find()->where('phone=:phone', [':phone' => $phone_1])->one();

        if (!is_object($client)) {
            Yii::error('Клиент с данным номер телефона не найден, phone:' . serialize($phone_1), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при сохранени нового клиента',
            ];
        }

        $newClientInfo->client_id = $client->id;
        $newClientInfo->email = $email;
        $newClientInfo->source = $source;
        $newClientInfo->rentals = 0;
        $newClientInfo->dohod = 0;
        $newClientInfo->sale = $sale;
        $newClientInfo->inn = $inn;
        $newClientInfo->kpp = $kpp;
        $newClientInfo->name_chief = $newClient->type === 2 ? $name_chief : '';
        $newClientInfo->phone_chief = $phone_3;
        $newClientInfo->phone_second = $phone_2;
        $newClientInfo->number_passport = $number_passport;
        $newClientInfo->date_birth = $date_birth;
        $newClientInfo->date_create = date('Y-m-d H:i:s');
        $newClientInfo->date_update = date('Y-m-d H:i:s');

        try {
            if (!$newClientInfo->save(false)) {
                Yii::error('Ошибка при добавлении дополнительной информации о клиенте: ' . serialize($newClientInfo->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при добавлении дополнительной информации о клиенте: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        Yii::info('Клиент успешно добавлен', __METHOD__);

        if ($clientId !== '') {
            return [
                'status' => 'SUCCESS',
                'msg' => 'Клиент успешно изменен'
            ];
        } else {
            $user = [
                'client_email' => $email,
                'client_fio' => $fio === '' ? $name : $fio,
                'client_id' => $newClientInfo->id,
                'client_number_passport' => $number_passport,
                'client_phone' => $phone_1,
                'client_type' => $type = $fio === '' ? 2 : 1
            ];

            return [
                'status' => 'SUCCESS',
                'msg' => 'Клиент успешно добавлен',
                'data' => $user
            ];
        }
    }

    /**
     * Добавление нового клиента
     * @param $clientId
     * @param $sale
     * @param $branch
     * @param $new_status
     * @param $old_status
     * @param $reason_change_status
     * @param $source
     * @param $inn
     * @param $kpp
     * @param $name_chief
     * @param $fio
     * @param $phone_1
     * @param $phone_2
     * @param $phone_3
     * @param $email
     * @param $number_passport
     * @param $name
     * @return array|bool
     * @throws \yii\base\InvalidConfigException
     */
    public static function UpdateClientInfo($clientId, $sale, $branch, $new_status, $old_status, $reason_change_status, $source, $inn, $kpp, $name_chief, $fio, $phone_1, $phone_2, $phone_3, $email, $number_passport, $name)
    {
        Yii::info('Запуск функции изменений детальной информации клиента', __METHOD__);

        if ($clientId === '') {
            Yii::error('Некорректный идентификатор клиента', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Некорректный идентификатор клиента'
            ];
        }

        if ($sale === '') {
            Yii::error('Не передано значение скидки, sale: ' . serialize($sale), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не передано значение скидки',
            ];
        }

        if ($branch === '') {
            Yii::error('Не передан идентификатор филиала, branch: ' . serialize($branch), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не передан идентификатор филиала'
            ];
        }

        if ($source === '') {
            Yii::error('Не передан идентификатор источника, source: ' . serialize($source), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не передан идентификатор источника',
            ];
        }

        if ($phone_1 === '') {
            Yii::error('Не передан номер телефона', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не передан номер телефона',
            ];
        } else if (($phone_1 !== '' && strlen($phone_1) !== 11) || ($phone_2 !== '' && strlen($phone_2) !== 11) || ($phone_3 !== '' && strlen($phone_3) !== 11)) {
            Yii::error('Указан некорректный номер телефона', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Указан некорректный номер телефона',
            ];
        }

        if ($email != '' && !preg_match("/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i", $email)) {
            Yii::error('Передан некорректный email, email:' . serialize($email), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Передан некорректный email',
            ];
        }

        $check_branch = Branch::find()->where('id=:id', [':id' => $branch])->one();

        if (!is_object($check_branch)) {
            Yii::error('Передан некорректный идентификатор филиала, branch:' . serialize($branch), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Передан некорректный идентификатор филиала',
            ];
        }

        $check_discount = Discount::find()->where('id=:id', [':id' => $sale])->one();

        if (!is_object($check_discount)) {
            Yii::error('Передан некорректный идентификатор скидки, sale:' . serialize($sale), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Передан некорректный идентификатор скидки',
            ];
        }

        $check_source = Source::find()->where('id=:id', [':id' => $source])->one();

        if (!is_object($check_source)) {
            Yii::error('Передан некорректный исчтоник, :' . serialize($source), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Передан некорректный исчтоник',
            ];
        }

        Yii::info('Обновление информациии о клиенте', __METHOD__);

        /**
         * @var Clients $clients
         */
        $clients = Clients::find()->where('id=:id', [':id' => $clientId])->one();

        if (!is_object($clients)) {
            Yii::error('Клиент не найден, id:' . serialize($clientId), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Клиент не найден',
            ];
        }

        $clients->name = $name === '' ? $fio : $name;
        $clients->phone = $phone_1;
        $clients->branch_id = $branch;

        try {
            if (!$clients->save(false)) {
                Yii::error('Ошибка при обновлении клиента: ' . serialize($clients->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при обновлении клиента: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        /**
         * @var ClientsInfo $clientsInfo
         */
        $clientsInfo = ClientsInfo::find()->where('client_id=:client_id', [':client_id' => $clientId])->one();

        if (!is_object($clientsInfo)) {
            Yii::error('Запись не найдена, client_id:' . serialize($clientId), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Клиент не найден',
            ];
        }

        $clientsInfo->source = $source;
        $clientsInfo->sale = $sale;
        $clientsInfo->email = $email;
        $clientsInfo->inn = $inn;
        $clientsInfo->kpp = $kpp;
        $clientsInfo->number_passport = $number_passport;
        $clientsInfo->name_chief = $name_chief;
        $clientsInfo->phone_chief = $phone_3;
        $clientsInfo->phone_second = $phone_2;
        $clientsInfo->date_update = date('Y-m-d H:i:s');

        try {
            if (!$clientsInfo->save(false)) {
                Yii::error('Ошибка при обновлении дополнительной информации о  клиенте: ' . serialize($clientsInfo->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при обновлении дополнительной информации о клиенте: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        if ($old_status !== $new_status) {
            Yii::info('Надо обновить статус', __METHOD__);

            $resultChange = self::UpdateStatusClientUr($clientId, $old_status, $new_status, $reason_change_status);

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
        }

        Yii::info('Клиент успешно обновлен', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Клиент успешно обновлен'
        ];
    }

    /**
     * @param $id
     * @param $old_status
     * @param $new_status
     * @param $text
     * @return array|bool
     * @throws \yii\base\InvalidConfigException
     */
    public static function UpdateStatusClientUr($id, $old_status, $new_status, $text)
    {
        Yii::info('Запуск функции UpdateStatusClientUr', __METHOD__);

        if ($id === '') {
            Yii::error('Не передан идентификтор клиента, id: ' . serialize($id), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не передан идентификтор клиента',
            ];
        }

        if ($old_status === '' || $new_status === '') {
            Yii::error('Ошибка при определении статуса, old_status: ' . serialize($old_status) . ', new_status: ' . serialize($new_status), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при определении статуса',
            ];
        }

        if ($text === '') {
            Yii::error('Ошибка при определении причины смены статуса, text: ' . serialize($text), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при определении причины смены статуса',
            ];
        }

        $check_status = ClientStatus::find()->where('id=:id', [':id' => $new_status])->one();

        if (!is_object($check_status)) {
            Yii::error('Передан некорректный статус, status:' . serialize($new_status), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Передан некорректный статус',
            ];
        }

        /**
         * @var Clients $client
         */
        $client = Clients::find()->where('id=:id', [':id' => $id])->one();

        if (!is_object($client)) {
            Yii::error('По данному идентификатору не найден клиент, id' . serialize($id), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Организация не найдена',
            ];
        }

        $client->status = $new_status;

        try {
            if (!$client->save(false)) {
                Yii::error('Ошибка при обновлении статуса клиента: ' . serialize($client->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при обновлении статуса клиента: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        /**
         * @var Sessions $Sessions
         */
        $Sessions = Yii::$app->get('Sessions');
        $session = $Sessions->getSession();

        if (!is_object($session)) {
            Yii::error('Ошибка при опредении пользователя', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при опредении пользователя'
            ];
        }

        $new_record = new ClientStatusChange();
        $new_record->client_id = $id;
        $new_record->old_status = $old_status;
        $new_record->new_status = $new_status;
        $new_record->text = $text;
        $new_record->user_id = $session->user_id;
        $new_record->date = date('Y-m-d H:i:s');

        try {
            if (!$new_record->save(false)) {
                Yii::error('Ошибка при добавлении записи о смене статуса клиента: ' . serialize($client->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при добавлении записи о смене статуса клиента: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        Yii::info('Статус клиента успешно изменен', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Статус клиента успешно изменен'
        ];
    }

    /**
     * Получение списка юр. клиентов
     * @param $type
     * @param $like
     * @param $source ,
     * @param $status ,
     * @param $branch ,
     * @param $date_start ,
     * @param $date_end ,
     * @param $rentals_start ,
     * @param $rentals_end ,
     * @param $dohod_start ,
     * @param $dohod_end
     * @return bool|array
     */
    public static function GetClient($type, $like, $source, $status, $branch, $date_start, $date_end, $rentals_start, $rentals_end, $dohod_start, $dohod_end)
    {
        Yii::info('Запуск функции GetClientUr', __METHOD__);

        $listFilter = [];
        $params = [];
        $result = [];

        if ($type === 'ur') {
            $listFilter[] = 'type=2';
        }
        if ($type === 'fiz') {
            $listFilter[] = 'type=1';
        }

        if ($like !== '' and $like !== null) {
            Yii::info('Параметр like: ' . serialize($like), __METHOD__);
            $like = '%' . $like . '%';
            $listFilter[] = 'name like :like';
            $params[':like'] = $like;
        }

        if ($branch !== '' and $branch !== null) {
            Yii::info('Параметр branch: ' . serialize($branch), __METHOD__);
            $listFilter[] = 'branch_id=:branch';
            $params[':branch'] = $branch;
        }

        if ($status !== '' and $status !== null) {
            Yii::info('Параметр status: ' . serialize($status), __METHOD__);
            $listFilter[] = 'status=:status';
            $params[':status'] = $status;
        }

        if ($date_start !== '' and $date_start !== null) {
            Yii::info('Параметр date_start: ' . serialize($date_start), __METHOD__);
            $listFilter[] = 'last_contact>:date_start';
            $params[':date_start'] = $date_start . ' 00:00:00';
        }

        if ($date_end !== '' and $date_end !== null) {
            Yii::info('Параметр date_end: ' . serialize($date_end), __METHOD__);
            $listFilter[] = 'last_contact<:date_end';
            $params[':date_end'] = $date_end . ' 23:59:59';
        }

        if (!empty($listFilter)) {
            $listFilter[] = 'is_not_active=0 and type!=3';
            $clients = Clients::find()->with('clientsInfos')->where(implode(" and ", $listFilter), $params)->orderBy('last_contact desc')->all();
        } else {
            $clients = Clients::find()->with('clientsInfos')->where('is_not_active=0 and type!=3')->orderBy('last_contact desc')->all();
        }

        if (is_array($clients)) {
            /**
             * @var Clients $value
             */
            foreach ($clients as $value) {
                $sourceBD = $value->clientsInfos[0]->source0;
                $discount = $value->clientsInfos[0]->sale0;

                if ($source !== '' && $source !== null && $source !== $sourceBD) {
                    continue;
                }

                if ($rentals_start !== '' && $rentals_start !== null) {
                    continue;
                }

                if ($rentals_end !== '' && $rentals_end !== null) {
                    continue;
                }

                if ($dohod_start !== '' && $dohod_start !== null) {
                    continue;
                }

                if ($dohod_end !== '' && $dohod_end !== null) {
                    continue;
                }

                $sum = ApplicationPay::find()->joinWith('cashBox0')->where('finance_cashbox.check_zalog=0 and client_id=:client_id', [':client_id' => $value->id])->sum('application_pay.sum');

                $count_app = Applications::find()->where('client_id=:client_id', [':client_id' => $value->id])->count();

                $result[] = [
                    'id' => $value->id,
                    'fio' => $value->type === 1 ? $value->name : $value->clientsInfos[0]->name_chief,
                    'org' => $value->type === 2 ? $value->name : '',
                    'type' => $value->type,
                    'phone' => $value->phone,
                    'bonus_account' => $value->clientsInfos[0]->bonus_account,
                    'old_status' => $value->status,
                    'new_status' => $value->status,
                    'color' => $value->status0->color,
                    'date_create' => date('d.m.Y', strtotime($value->date_create)),
                    'last_contact' => date('d.m.Y', strtotime($value->last_contact)),
                    'source' => ['id' => $sourceBD->id, 'name' => $sourceBD->name],
                    'sale' => ['code' => $discount->code, 'name' => $discount->name],
                    'sum_pay' => +$sum,
                    'count_app' => $count_app
                ];
            }
        }


        Yii::info('Список клиентов успешно получен' . serialize($result), __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Список клиентов успешно получен',
            'data' => $result
        ];
    }

    /**
     * Получение списка полей
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public static function GetFields()
    {
        Yii::info('Запуск функции GetFields', __METHOD__);
        $result = [];

        $clientsFieldList = ClientField::find()->orderBy('id')->all();

        if (!is_array($clientsFieldList)) {
            Yii::error('Список полей пуст', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Список полей пуст'
            ];
        }

        /**
         * @var Sessions $Sessions
         */
        $Sessions = Yii::$app->get('Sessions');
        $session = $Sessions->getSession();

        if (!is_object($session)) {
            Yii::error('Ошибка при опредении пользователя', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при опредении пользователя'
            ];
        }

        /**
         * @var ClientField $value
         */
        foreach ($clientsFieldList as $value) {
            $check_flag = ClientShowField::find()->where('equipments_field_id=:equipments_field_id and user_id=:user_id', [':equipments_field_id' => $value->id, ':user_id' => $session->user_id])->orderBy('id')->one();

            $flag = is_object($check_flag) ? 0 : 1;

            $result[] = [
                'id' => $value->id,
                'code' => $value->code,
                'name' => $value->name,
                'flag' => $flag
            ];
        }

        Yii::info('Список полей получен', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Список полей получен',
            'data' => $result
        ];
    }

    /**
     * Изменение списка отображаемых полей для таблицы "Клиенты"
     * @param $params
     * @return array|bool
     * @throws \yii\base\InvalidConfigException
     */
    public static function ChangeFields($params)
    {
        Yii::info('Запуск функции ChangeFields', __METHOD__);

        if (!is_array($params) || empty($params)) {
            Yii::error('Не пришли параметры для изменения', __METHOD__);
        }

        /**
         * @var Sessions $Sessions
         */
        $Sessions = Yii::$app->get('Sessions');
        $session = $Sessions->getSession();

        if (!is_object($session)) {
            Yii::error('Ошибка при опредении пользователя', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при опредении пользователя'
            ];
        }

        try {
            ClientShowField::deleteAll('user_id=:user_id', [':user_id' => $session->user_id]);
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при очистке списка скрытых полей : ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        foreach ($params as $value) {
            if ($value->flag === 0) {

                $newVal = new ClientShowField();
                $newVal->user_id = $session->user_id;
                $newVal->equipments_field_id = $value->id;

                try {
                    if (!$newVal->save(false)) {
                        Yii::error('Ошибка при изменени отображения поля: ' . serialize($newVal->getErrors()), __METHOD__);
                        return false;
                    }
                } catch (\Exception $e) {
                    Yii::error('Поймали Exception при изменени отображения поля: ' . serialize($e->getMessage()), __METHOD__);
                    return false;
                }
            }
        }

        Yii::info('Поля успешно изменены', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Поля успешно изменены'
        ];
    }

    /**
     * Получение детальной информации по клиенту
     * @param $clientId
     * @return bool|array
     */
    public static function GetDetailInfoClient($clientId)
    {
        Yii::info('Запуск функции GetDetailInfoClient', __METHOD__);

        if ($clientId === '') {
            Yii::error('Некорректный идентификатор клиента', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Некорректный идентификатор клиента'
            ];
        }

        /**
         * @var Clients $client
         */
        $client = Clients::find()->where('id=:id', [':id' => $clientId])->one();

        if (!is_object($client)) {
            Yii::error('Клиент с таким идентификатором не найден, id: ' . serialize($clientId), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Клиент с таким идентификатором не найден'
            ];
        }

        $sourceBD = $client->clientsInfos[0]->source0;
        $discount = $client->clientsInfos[0]->sale0;
        $branch = $client->branch;
        $status = $client->status0;
        $all_total_paid = 0;
        $pay_list = [];
        $application_list = [];
        $change_status_list = [];

        $application_listArr = Applications::find()->where('client_id=:user_id', [':user_id' => $client->id])->all();

        if (!empty($application_listArr)) {
            /**
             * @var Applications $value
             */
            foreach ($application_listArr as $value) {
                foreach ($value->applicationEquipments as $value_2) {
                    $application_list[] = [
                        'rent_start' => date('d.m.Y H:i:s', strtotime($value->rent_start)),
                        'rent_end' => date('d.m.Y H:i:s', strtotime($value->rent_end)),
                        'sum' => $value_2->sum,
                        'total_paid' => $value_2->total_paid,
                        'equipments' => $value_2->equipments->type0->name . ' ' . $value_2->equipments->mark0->name . ' ' . $value_2->equipments->model
                    ];

                    foreach ($value_2->applicationPays as $value3) {
                        $pay_list[] = [
                            'sum' => $value3->sum,
                            'date' => date('d.m.Y H:i:s', strtotime($value3->date_create)),
                            'equipments' => $value_2->equipments->type0->name . ' ' . $value_2->equipments->mark0->name . ' ' . $value_2->equipments->model,
                            'cashBox' => $value3->cashBox0->name
                        ];
                    }


                    $all_total_paid += (float)$value_2->total_paid;
                }
            }
        }

        $change_status_list_arr = $client->clientStatusChanges;

        if (!empty($change_status_list_arr)) {
            /**
             * @var ClientStatusChange $value
             */
            foreach ($change_status_list_arr as $value) {
                $change_status_list[] = [
                    'date' => date('d.m.Y H:i:s', strtotime($value->date)),
                    'old_status' => $value->oldStatus->name,
                    'new_status' => $value->newStatus->name,
                    'text' => $value->text,
                    'user' => $value->user->fio,
                ];
            }
        }

        $result = [
            'id' => $client->id,
            'sale' => $discount->id,
            'branch' => $branch->id,
            'old_status' => $status->id,
            'new_status' => $status->id,
            'source' => $sourceBD->id,
            'phone_1' => $client->phone,
            'fio' => $client->type === 1 ? $client->name : '',
            'name' => $client->type === 2 ? $client->name : '',
            'inn' => $client->clientsInfos[0]->inn,
            'email' => $client->clientsInfos[0]->email,
            'kpp' => $client->clientsInfos[0]->kpp,
            'name_chief' => $client->clientsInfos[0]->name_chief,
            'bonus_account' => $client->clientsInfos[0]->bonus_account,
            'phone_3' => $client->clientsInfos[0]->phone_chief,
            'phone_2' => $client->clientsInfos[0]->phone_second,
            'date_birth' => $client->clientsInfos[0]->date_birth,
            'phone' => $client->phone,
            'count_application' => count($application_list),
            'all_total_paid' => $all_total_paid,
            'application_list' => $application_list,
            'pay_list' => $pay_list,
            'change_status_list' => $change_status_list
        ];

        Yii::info('Информация по клиенту успешно получена', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Информация по клиенту успешно получена',
            'data' => $result
        ];
    }

    /**
     * Получение списка клиентов
     * @param $like
     * @return bool|array
     */
    public static function GetSearchClient($like)
    {
        Yii::info('Запуск функции GetSearchClient', __METHOD__);

        $result = [];

        if ($like === '') {
            Yii::error('Не передан параметр поиска', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не передан параметр поиска'
            ];
        }

        $like = '%' . $like . '%';

        $clients = Clients::find()->where('is_not_active=0 and name like :like', [':like' => $like])->limit(10)->all();

        if (!is_array($clients)) {
            Yii::error('Клиенты не найдены, like: ' . serialize($like), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Клиенты не найдены'
            ];
        }

        /**
         * @var Clients $value
         */
        foreach ($clients as $value) {
            $result[] = [
                'client_id' => $value->id,
                'client_fio' => $value->name,
                'client_email' => $value->clientsInfos[0]->inn,
                'client_phone' => $value->phone,
                'client_type' => $value->type,
                'client_number_passport' => $value->clientsInfos[0]->number_passport,
            ];
        }

        Yii::info('Клиенты успешно получены', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Клиенты успешно получены',
            'data' => $result
        ];
    }

    /**
     * Получение списка всех клиентов
     * @param $branch
     * @return bool|array
     */
    public static function GetAllClient($branch)
    {
        Yii::info('Запуск функции GetAllClient', __METHOD__);

        $result = [];

        $clients = Clients::find()->where('branch_id = :branch and phone!="79111111111"', [':branch' => $branch])->all();

        if (empty($clients)) {
            Yii::error('Клиенты не найдены, like: ' . serialize($branch), __METHOD__);

            return [
                'status' => 'SUCCESS',
                'msg' => 'Клиенты не найдены',
                'data' => []
            ];
        }

        Yii::error('ololo: ' . serialize($clients), __METHOD__);

        /**
         * @var Clients $value
         */
        foreach ($clients as $value) {


            $result[] = [
                'client_id' => $value->id,
                'client_fio' => $value->name,
                'client_email' => $value->clientsInfos[0]->inn,
                'client_phone' => $value->phone,
                'client_number_passport' => $value->clientsInfos[0]->number_passport,
            ];
        }


        Yii::info('Клиенты успешно получены', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Клиенты успешно получены',
            'data' => $result
        ];
    }

    /**
     * Получение списка всех клиентов
     * @param $client_id
     * @return Clients
     */
    public static function GetClientInfo($client_id)
    {
        Yii::info('Запуск функции GetClientInfo', __METHOD__);

        /**
         * @var Clients $client
         */
        $client = Clients::find()->where('id=:id', [':id' => $client_id])->one();

        Yii::info('Клиенты успешно получены', __METHOD__);

        if (!is_object($client)) {
            $client = (object)[
                'id' => '',
                'phone' => '',
                'name' => ''
            ];
        }

        return $client;
    }

    /**
     * Удаление клиента
     * @param $id
     * @return bool|array
     */
    public static function DeleteClient($id)
    {
        Yii::info('Запуск функции GetAllClient', __METHOD__);

        $result = [];

        /**
         * @var Clients $client
         */
        $client = Clients::find()->where('id = :id', [':id' => $id])->one();

        if (!is_object($client)) {
            Yii::error('Клиент не найден, id: ' . serialize($id), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Клиент не найден'
            ];
        }

        $client->is_not_active = 1;

        try {
            if (!$client->save(false)) {
                Yii::error('Ошибка при удалении клиента: ' . serialize($client->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при удалении клиента: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }


        Yii::info('Клиенты успешно удален', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Клиенты успешно удален'
        ];
    }

    /**
     * Изменение бонусного счета
     * @param $id
     * @param $sum
     * @param $revertSum
     * @return bool|array
     */
    public static function changeBonusAccountClient($id, $sum, $revertSum = false)
    {
        Yii::info('Функция изменения бонусного счета', __METHOD__);

        /**
         * @var Clients $client
         */
        $client = Clients::find()->where('id=:id', [':id' => $id])->one();

        if (!is_object($client)) {
            Yii::error('Клиент не найден, id: ' . serialize($id), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Клиент не найден'
            ];
        }

        /**
         * @var Settings $settings
         */
        $settings = Settings::find()->where('id=1')->one();

        if (!is_object($settings)) {
            Yii::error('Настройки не найдены', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Настройки не найдены'
            ];
        }

        $bonus_account = round($sum * ((float)$settings->value / 100), 0);

        $clientsInfos = $client->clientsInfos[0];

        if ($revertSum) {
            $clientsInfos->bonus_account = (float)$clientsInfos->bonus_account - (float)$bonus_account;
        } else {
            $clientsInfos->bonus_account = (float)$clientsInfos->bonus_account + (float)$bonus_account;
        }

        try {
            if (!$clientsInfos->save(false)) {
                Yii::error('Ошибка при изменении бонусного счета клиента: ' . serialize($clientsInfos->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при изменении бонусного счета клиента: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        Yii::info('Бонусный счет успешно изменен', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Бонусный счет успешно изменен'
        ];
    }
}