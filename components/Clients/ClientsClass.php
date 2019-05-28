<?php
/**
 * Управление клиентами
 */

namespace app\components\Clients;

use app\models\ClientFiz;
use app\models\ClientSource;
use app\models\ClientStatus;
use app\models\ClientUr;
use app\models\ShowFieldClient;
use Yii;

class ClientsClass
{

    /**
     * Добавление нового юр. клиента
     * @param $name_org ,
     * @param $phone ,
     * @param $status ,
     * @param $last_contact ,
     * @param $source ,
     * @param $rentals ,
     * @param $dohod ,
     * @param $sale ,
     * @return bool|array
     */
    public static function AddClientUr($name_org, $phone, $status, $last_contact, $source, $rentals, $dohod, $sale)
    {
        Yii::info('Запуск функции добавления юридического клиента', __METHOD__);

        if ($name_org === '') {
            Yii::error('Ни передано наименование организации, name_org: ' . serialize($name_org), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ни передано наименование организации',
            ];
        }

        if ($phone === '' || strlen($phone) !== 11) {
            Yii::error('Ошибка при проверке номера телефона, phone: ' . serialize($phone), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при проверке номера телефона'
            ];
        }

        if ($last_contact === '') {
            Yii::error('Ни передано дата последнего контакта, last_contact: ' . serialize($last_contact), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ни передано дата последнего контакта',
            ];
        }

        if ($status === '') {
            Yii::error('Передан некорректный статус, status: ' . serialize($status), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Передан некорректный статус',
            ];
        }

        if ($source === '') {
            Yii::error('Ни передан источник, source: ' . serialize($source), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ни передан источник',
            ];
        }

        if ($rentals === '') {
            Yii::error('Ни передано количество прокатов, rentals: ' . serialize($rentals), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ни передано количество прокатов',
            ];
        }

        if ($dohod === '') {
            Yii::error('Ни передан доход, dohod: ' . serialize($dohod), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ни передан доход',
            ];
        }

        if ($sale === '') {
            Yii::error('Ни передана скида, sale: ' . serialize($sale), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ни передана скида',
            ];
        }

        $check_source = ClientSource::find()->where('id=:id', [':id' => $source])->one();

        if (!is_object($check_source)) {
            Yii::error('Передан некорректный источник, source:' . serialize($source), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Указанный источник не существует',
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

        $client_ur = new ClientUr();
        $client_ur->name_org = $name_org;
        $client_ur->phone = $phone;
        $client_ur->status = $status;
        $client_ur->last_contact = $last_contact;
        $client_ur->source = $source;
        $client_ur->rentals = $rentals;
        $client_ur->dohod = $dohod;
        $client_ur->sale = $sale;
        $client_ur->date_create = date('Y-m-d H:i:s');

        try {
            if (!$client_ur->save(false)) {
                Yii::error('Ошибка при добавлении юр. клиента: ' . serialize($client_ur->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при добавлении юр. клиента: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        Yii::info('Юр. клиент успешно добавлен', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Юр. клиент успешно добавлен'
        ];
    }

    /**
     * Изменение статуса юр. клиента
     * @param $id
     * @param $status
     * @param $client_type
     * @return bool|array
     */
    public static function UpdateStatusClientUr($id, $status, $client_type)
    {
        Yii::info('Запуск функции UpdateStatusClientUr', __METHOD__);

        if ($id === '' || !is_int($status)) {
            Yii::error('Ни передан идентификтор организации, id: ' . serialize($id), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ни передан идентификтор организации',
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

        if ($client_type === 'ur') {
            /**
             * @var ClientUr $client
             */
            $client = ClientUr::find()->where('id=:id', [':id' => $id])->one();

            if (!is_object($client)) {
                Yii::error('По данному идентификатору ни найдена организация, id' . serialize($id), __METHOD__);

                return [
                    'status' => 'ERROR',
                    'msg' => 'Организация ни найдена',
                ];
            }
        } else {
            /**
             * @var ClientFiz $client
             */
            $client = ClientFiz::find()->where('id=:id', [':id' => $id])->one();

            if (!is_object($client)) {
                Yii::error('По данному идентификатору ни найдена организация, id' . serialize($id), __METHOD__);

                return [
                    'status' => 'ERROR',
                    'msg' => 'Организация ни найдена',
                ];
            }
        }

        $client->status = $status;

        try {
            if (!$client->save(false)) {
                Yii::error('Ошибка при обновлении статуса юр. клиента: ' . serialize($client->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при обновлении статуса юр. клиента: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        Yii::info('Статус юр. клиента успешно изменен', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Статус юр. клиента успешно изменен'
        ];
    }

    /**
     * Получение списка юр. клиентов
     * @param $type
     * @param $like
     * @param $source ,
     * @param $status ,
     * @param $date_start ,
     * @param $date_end ,
     * @param $rentals_start ,
     * @param $rentals_end ,
     * @param $dohod_start ,
     * @param $dohod_end
     * @return bool|array
     */
    public static function GetClient($type, $like, $source, $status, $date_start, $date_end, $rentals_start, $rentals_end, $dohod_start, $dohod_end)
    {
        Yii::info('Запуск функции GetClientUr', __METHOD__);

        $client_ur = ClientUr::find();
        $client_fiz = ClientFiz::find();
        $listUr = [];
        $listFiz = [];

        $params = [];

        $resultUr = [];
        $resultFiz = [];

        if ($like !== '' and $source !== null) {
            Yii::info('Параметр like: ' . serialize($like), __METHOD__);
            $like = '%' . $like . '%';
            $listUr[] = 'name_org like :like';
            $listFiz[] = 'fio like :like';
            $params[':like'] = $like;
        }

        if ($source !== '' and $source !== null) {
            Yii::info('Параметр source: ' . serialize($source), __METHOD__);
            $listFiz[] = $listUr[] = 'source=:source';
            $params[':source'] = $source;
        }

        if ($status !== '' and $status !== null) {
            Yii::info('Параметр status: ' . serialize($status), __METHOD__);
            $listFiz[] = $listUr[] = 'status=:status';
            $params[':status'] = $status;
        }

        if ($date_start !== '' and $date_start !== null) {
            Yii::info('Параметр date_start: ' . serialize($date_start), __METHOD__);
            $listFiz[] = $listUr[] = 'last_contact>:date_start';
            $params[':date_start'] = $date_start . ' 00:00:00';
        }

        if ($date_end !== '' and $date_end !== null) {
            Yii::info('Параметр date_end: ' . serialize($date_end), __METHOD__);
            $listFiz[] = $listUr[] = 'last_contact<:date_end';
            $params[':date_end'] = $date_end . ' 23:59:59';
        }

        if ($rentals_start !== '' and $rentals_start !== null) {
            Yii::info('Параметр rentals_start: ' . serialize($rentals_start), __METHOD__);
            $listFiz[] = $listUr[] = 'rentals>=:rentals_start';
            $params[':rentals_start'] = $rentals_start;
        }

        if ($rentals_end !== '' and $rentals_end !== null) {
            Yii::info('Параметр rentals_end: ' . serialize($rentals_end), __METHOD__);
            $listFiz[] = $listUr[] = 'rentals<=:rentals_end';
            $params[':rentals_end'] = $rentals_end;
        }

        if ($dohod_start !== '' and $dohod_start !== null) {
            Yii::info('Параметр dohod_start: ' . serialize($dohod_start), __METHOD__);
            $listFiz[] = $listUr[] = 'dohod>=:dohod_start';
            $params[':dohod_start'] = $dohod_start;
        }

        if ($dohod_end !== '' and $dohod_end !== null) {
            Yii::info('Параметр dohod_end: ' . serialize($dohod_end), __METHOD__);
            $listFiz[] = $listUr[] = 'dohod<=:dohod_end';
            $params[':dohod_end'] = $dohod_end;
        }

        if ($type === 'all' || $type === 'ur') {
            if (!empty($listUr)) {
                $client_ur = $client_ur->where(implode(" and ", $listUr), $params)->orderBy('last_contact desc')->all();
            } else {
                $client_ur = $client_ur->orderBy('last_contact desc')->all();
            }

            if (is_array($client_ur)) {
                /**
                 * @var ClientUr $value
                 */
                foreach ($client_ur as $value) {
                    $source = $value->source0;

                    $resultUr[] = [
                        'id' => $value->id,
                        'fio' => '',
                        'org' => $value->name_org,
                        'phone' => $value->phone,
                        'status' => $value->status,
                        'date_create' => date('d.m.Y', strtotime($value->date_create)),
                        'last_contact' => date('d.m.Y', strtotime($value->last_contact)),
                        'source' => ['id' => $source->id, 'name' => $source->name],
                        'rentals' => $value->rentals,
                        'dohod' => $value->dohod,
                        'sale' => $value->sale,
                        'type' => 'ur'
                    ];
                }
            }
        }

        if ($type === 'all' || $type === 'fiz') {
            if (!empty($listFiz)) {
                $client_fiz = $client_fiz->where(implode(" and ", $listFiz), $params)->orderBy('last_contact desc')->all();
            } else {
                $client_fiz = $client_fiz->orderBy('last_contact desc')->all();
            }

            if (is_array($client_fiz)) {
                /**
                 * @var ClientFiz $value
                 */
                foreach ($client_fiz as $value) {
                    $source = $value->source0;
                    $org = $value->org_id ? $value->org->name_org : '';

                    $resultFiz[] = [
                        'id' => $value->id,
                        'fio' => $value->fio,
                        'org' => $org,
                        'phone' => $value->phone,
                        'status' => $value->status,
                        'date_create' => date('d.m.Y', strtotime($value->date_create)),
                        'last_contact' => date('d.m.Y', strtotime($value->last_contact)),
                        'source' => ['id' => $source->id, 'name' => $source->name],
                        'rentals' => $value->rentals,
                        'dohod' => $value->dohod,
                        'sale' => $value->sale,
                        'type' => 'fiz'
                    ];
                }
            }
        }

        $result = array_merge($resultUr, $resultFiz);

        Yii::info('Список клиентов успешно получен' . serialize($result), __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Список клиентов успешно получен',
            'data' => $result
        ];
    }

    /**
     * Поиск юр. клиентов
     * @param $params
     * @return bool|array
     */
    public static function SearchClientUr($params)
    {
        Yii::info('Запуск функции SearchClientUr', __METHOD__);
        $result = [];

        /**
         * @var ClientUr $client_ur
         */
        $client_ur = ClientUr::find()->andFilterWhere(['like', 'name_org', $params])->all();

        if (!is_array($client_ur)) {
            Yii::error('Список юр. лиц пуст', __METHOD__);

            return [
                'status' => 'SUCCESS',
                'msg' => 'Список юр. лиц пуст',
                'data' => $result
            ];
        }

        /**
         * @var ClientUr $value
         */
        foreach ($client_ur as $value) {
            $source = $value->source0;

            $result[] = [
                'id' => $value->id,
                'name' => $value->name_org,
                'phone' => $value->phone,
                'status' => $value->status,
                'date_create' => date('d.m.Y', strtotime($value->date_create)),
                'last_contact' => date('d.m.Y', strtotime($value->last_contact)),
                'source' => ['id' => $source->id, 'name' => $source->name],
                'rentals' => $value->rentals,
                'dohod' => $value->dohod,
                'sale' => $value->sale,
            ];
        }

        Yii::info('Список юр. клиентов успешно получен', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Список юр. клиентов успешно получен',
            'data' => $result
        ];
    }

    /**
     * Получение списка полей
     * @return bool|array
     */
    public static function GetFields()
    {
        Yii::info('Запуск функции GetFields', __METHOD__);
        $result = [];

        $showFieldClient = ShowFieldClient::find()->all();

        if (!is_array($showFieldClient)) {
            Yii::error('Список полей пуст', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при получении полей'
            ];
        }

        /**
         * @var ShowFieldClient $value
         */
        foreach ($showFieldClient as $value) {
            $result[] = [
                'code' => $value->code,
                'name' => $value->name,
                'flag' => (int)$value->flag
            ];
        }

        Yii::info('Список полей успешно получен', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Список полей успешно получен',
            'data' => $result
        ];
    }


    /**
     * Изменение списка отображаемых полей для таблицы "Клиенты"
     * @param $params
     * @return bool|array
     */
    public static function ChangeFields($params)
    {
        Yii::info('Запуск функции ChangeFields'.serialize($params), __METHOD__);

        if (!is_array($params) || empty($params)) {
            Yii::error('Не пришли параметры для изменения', __METHOD__);
        }

        /**
         * @var ShowFieldClient $value
         */
        foreach ($params as $value) {
            try {
                ShowFieldClient::updateAll(['flag' => $value->flag], 'code= :code', [':code' => $value->code]);
            } catch (\Exception $e) {
                Yii::error('Поймали Exception при обновлении флага отображения поля: ' . serialize($e->getMessage()), __METHOD__);

                return false;
            }
        }

        Yii::info('Список полей успешно изменен', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Список полей успешно изменен'
        ];
    }
}