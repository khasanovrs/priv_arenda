<?php
/**
 * Управление клиентами
 */

namespace app\components\Clients;

use app\components\Session\Sessions;
use app\models\Branch;
use app\models\ClientField;
use app\models\ClientFiz;
use app\models\ClientFizInfo;
use app\models\Clients;
use app\models\ClientShowField;
use app\models\ClientsInfo;
use app\models\ClientSource;
use app\models\ClientStatus;
use app\models\ClientUr;
use app\models\ClientUrInfo;
use app\models\Discount;
use app\models\ShowFieldClient;
use app\models\Source;
use Yii;

class ClientsClass
{
    /**
     * Добавление нового клиента
     * @param $sale ,
     * @param $branch ,
     * @param $status ,
     * @param $source ,
     * @param $name ,
     * @param $inn ,
     * @param $occupation ,
     * @param $address ,
     * @param $ogrn ,
     * @param $bic ,
     * @param $kpp ,
     * @param $schet ,
     * @param $name_chief ,
     * @param $phone_chief ,
     * @param $phone ,
     * @param $email ,
     * @param $number_passport ,
     * @param $where_passport ,
     * @param $date_passport ,
     * @param $address_passport
     * @return bool|array
     */
    public static function AddClient($sale, $branch, $status, $source, $name, $inn, $occupation, $address, $ogrn, $bic, $kpp, $schet, $name_chief, $phone_chief, $phone, $phone_2, $email, $number_passport, $where_passport, $date_passport, $address_passport)
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

        if ($status === '') {
            Yii::error('Не передан идентификатор статуса, status: ' . serialize($status), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не передан идентификатор статуса',
            ];
        }

        if ($source === '') {
            Yii::error('Не передан идентификатор источника, source: ' . serialize($source), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не передан идентификатор источника',
            ];
        }

        if ($phone_chief === '' && $phone === '' && $phone_2 === '') {
            Yii::error('Не передан номер телефона', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не передан номер телефона',
            ];
        } else if (($phone_chief !== '' && strlen($phone_chief) !== 11) || ($phone !== '' && strlen($phone) !== 11) || ($phone_2 !== '' && strlen($phone_2) !== 11)) {
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

        $check_status = ClientStatus::find()->where('id=:id', [':id' => $status])->one();

        if (!is_object($check_status)) {
            Yii::error('Передан некорректный статус, status:' . serialize($status), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Передан некорректный статус',
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

        $check_phone = Clients::find()->where('phone=:phone', [':phone' => $phone])->one();

        if (is_object($check_phone)) {
            Yii::error('Клиент с данным номер телефона уже зарегестрирован, phone:' . serialize($phone), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Клиент с данным номер телефона уже зарегестрирован',
            ];
        }

        $newClient = new Clients();
        $newClient->name = $name === '' ? $name_chief : $name;
        $newClient->type = $name !== '' ? 2 : 1;
        $newClient->phone = $phone;
        $newClient->status = $status;
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
        $client = Clients::find()->where('phone=:phone', [':phone' => $phone])->one();

        if (!is_object($client)) {
            Yii::error('Клиент с данным номер телефона не найден, phone:' . serialize($phone), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при сохранени нового клиента',
            ];
        }

        $newClientInfo = new ClientsInfo();
        $newClientInfo->client_id = $client->id;
        $newClientInfo->email = $email;
        $newClientInfo->source = $source;
        $newClientInfo->rentals = 0;
        $newClientInfo->dohod = 0;
        $newClientInfo->sale = $sale;
        $newClientInfo->address = $address;
        $newClientInfo->inn = $inn;
        $newClientInfo->occupation = $occupation;
        $newClientInfo->ogrn = $ogrn;
        $newClientInfo->bic = $bic;
        $newClientInfo->kpp = $kpp;
        $newClientInfo->schet = $schet;
        $newClientInfo->name_chief = $name_chief;
        $newClientInfo->phone_chief = $phone_chief;
        $newClientInfo->phone_second = $phone_2;
        $newClientInfo->number_passport = $number_passport;
        $newClientInfo->where_passport = $where_passport;
        $newClientInfo->date_passport = $date_passport;
        $newClientInfo->address_passport = $address_passport;
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

        return [
            'status' => 'SUCCESS',
            'msg' => 'Клиент успешно добавлен'
        ];
    }

    /**
     * Добавление нового клиента
     * @param $clientId ,
     * @param $sale ,
     * @param $branch ,
     * @param $status ,
     * @param $source ,
     * @param $name ,
     * @param $inn ,
     * @param $occupation ,
     * @param $address ,
     * @param $ogrn ,
     * @param $bic ,
     * @param $kpp ,
     * @param $schet ,
     * @param $name_chief ,
     * @param $phone_chief ,
     * @param $phone ,
     * @param $email ,
     * @return bool|array
     */
    public static function UpdateClientInfo($clientId, $sale, $branch, $status, $source, $name, $inn, $occupation, $address, $ogrn, $bic, $kpp, $schet, $name_chief, $phone_chief, $phone, $phone_2, $email)
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

        if ($status === '') {
            Yii::error('Не передан идентификатор статуса, status: ' . serialize($status), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не передан идентификатор статуса',
            ];
        }

        if ($source === '') {
            Yii::error('Не передан идентификатор источника, source: ' . serialize($source), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не передан идентификатор источника',
            ];
        }

        if ($phone_chief === '' && $phone === '' && $phone_2 === '') {
            Yii::error('Не передан номер телефона', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не передан номер телефона',
            ];
        } else if (($phone_chief !== '' && strlen($phone_chief) !== 11) || ($phone !== '' && strlen($phone) !== 11) || ($phone_2 !== '' && strlen($phone_2) !== 11)) {
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

        $check_status = ClientStatus::find()->where('id=:id', [':id' => $status])->one();

        if (!is_object($check_status)) {
            Yii::error('Передан некорректный статус, status:' . serialize($status), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Передан некорректный статус',
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

        $clients->name = $name;
        $clients->phone = $phone;
        $clients->status = $status;
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
        $clientsInfo->address = $address;
        $clientsInfo->inn = $inn;
        $clientsInfo->occupation = $occupation;
        $clientsInfo->ogrn = $ogrn;
        $clientsInfo->bic = $bic;
        $clientsInfo->kpp = $kpp;
        $clientsInfo->schet = $schet;
        $clientsInfo->name_chief = $name_chief;
        $clientsInfo->phone_chief = $phone_chief;
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

        Yii::info('Клиент успешно обновлен', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Клиент успешно обновлен'
        ];
    }

    /**
     * Изменение статуса юр. клиента
     * @param $id
     * @param $status
     * @return bool|array
     */
    public static function UpdateStatusClientUr($id, $status)
    {
        Yii::info('Запуск функции UpdateStatusClientUr', __METHOD__);

        if ($id === '' || !is_int($status)) {
            Yii::error('Не передан идентификтор организации, id: ' . serialize($id), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не передан идентификтор организации',
            ];
        }

        if ($status === '' || !is_int($status)) {
            Yii::error('Передан некорректный статус, status: ' . serialize($status), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Передан некорректный статус',
            ];
        }

        $check_status = ClientStatus::find()->where('id=:id', [':id' => $status])->one();

        if (!is_object($check_status)) {
            Yii::error('Передан некорректный статус, status:' . serialize($status), __METHOD__);

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

        $client->status = $status;

        try {
            if (!$client->save(false)) {
                Yii::error('Ошибка при обновлении статуса клиента: ' . serialize($client->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при обновлении статуса клиента: ' . serialize($e->getMessage()), __METHOD__);
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
            $clients = Clients::find()->with('clientsInfos')->where(implode(" and ", $listFilter), $params)->orderBy('last_contact desc')->all();
        } else {
            $clients = Clients::find()->with('clientsInfos')->orderBy('last_contact desc')->all();
        }

        if (is_array($clients)) {
            /**
             * @var Clients $value
             */
            foreach ($clients as $value) {
                $sourceBD = $value->clientsInfos[0]->source0;
                $discount = $value->clientsInfos[0]->sale0;
                $rentalsBD = $value->clientsInfos[0]->rentals;
                $dohodBD = $value->clientsInfos[0]->dohod;

                if ($source !== '' && $source !== null && $source !== $sourceBD) {
                    continue;
                }

                if ($rentals_start !== '' && $rentals_start !== null && $rentals_start > $rentalsBD) {
                    continue;
                }

                if ($rentals_end !== '' && $rentals_end !== null && $rentals_end < $rentalsBD) {
                    continue;
                }

                if ($dohod_start !== '' && $dohod_start !== null && $dohod_start > $dohodBD) {
                    continue;
                }

                if ($dohod_end !== '' && $dohod_end !== null && $dohod_end < $dohodBD) {
                    continue;
                }

                $result[] = [
                    'id' => $value->id,
                    'fio' => $value->type === 1 ? $value->name : '',
                    'org' => $value->type === 2 ? $value->name : '',
                    'type' => $value->type,
                    'phone' => $value->phone,
                    'status' => $value->status,
                    'color' => $value->status0->color,
                    'date_create' => date('d.m.Y', strtotime($value->date_create)),
                    'last_contact' => date('d.m.Y', strtotime($value->last_contact)),
                    'source' => ['id' => $sourceBD->id, 'name' => $sourceBD->name],
                    'rentals' => $rentalsBD,
                    'dohod' => $dohodBD,
                    'sale' => ['code' => $discount->code, 'name' => $discount->name],
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

        $result = [
            'id' => $client->id,
            'sale' => $discount->id,
            'branch' => $branch->id,
            'status' => $status->id,
            'source' => $sourceBD->id,
            'fio' => $client->type === 1 ? $client->name : '',
            'name' => $client->type === 2 ? $client->name : '',
            'inn' => $client->clientsInfos[0]->inn,
            'email' => $client->clientsInfos[0]->email,
            'occupation' => $client->clientsInfos[0]->occupation,
            'address' => $client->clientsInfos[0]->address,
            'ogrn' => $client->clientsInfos[0]->ogrn,
            'bic' => $client->clientsInfos[0]->bic,
            'kpp' => $client->clientsInfos[0]->kpp,
            'schet' => $client->clientsInfos[0]->schet,
            'name_chief' => $client->clientsInfos[0]->name_chief,
            'phone_chief' => $client->clientsInfos[0]->phone_chief,
            'phone_2' => $client->clientsInfos[0]->phone_second,
            'phone' => $client->phone,
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

        $clients = Clients::find()->where('name like :like', [':like' => $like])->limit(10)->all();

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
                'client_number_passport' => $value->clientsInfos[0]->number_passport,
                'client_where_passport' => $value->clientsInfos[0]->where_passport,
                'client_date_passport' => date('Y-m-d', strtotime($value->clientsInfos[0]->date_passport)),
                'client_address_passport' => $value->clientsInfos[0]->address_passport
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
     * @param $like
     * @return bool|array
     */
    public static function GetAllClient($like)
    {
        Yii::info('Запуск функции GetAllClient', __METHOD__);

        $result = [];

        if ($like === '') {
            Yii::error('Не передан параметр поиска', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не передан параметр поиска'
            ];
        }

        $like = '%' . $like . '%';

        $clients = Clients::find()->all();

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
                'client_number_passport' => $value->clientsInfos[0]->number_passport,
                'client_where_passport' => $value->clientsInfos[0]->where_passport,
                'client_date_passport' => date('Y-m-d', strtotime($value->clientsInfos[0]->date_passport)),
                'client_address_passport' => $value->clientsInfos[0]->address_passport
            ];
        }


        Yii::info('Клиенты успешно получены', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Клиенты успешно получены',
            'data' => $result
        ];
    }


}