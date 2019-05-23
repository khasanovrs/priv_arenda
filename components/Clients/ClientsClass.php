<?php
/**
 * Управление клиентами
 */

namespace app\components\Clients;

use app\models\ClientSource;
use app\models\ClientStatus;
use app\models\ClientUr;
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
     * @return bool|array
     */
    public static function UpdateStatusClientUr($id, $status)
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

        /**
         * @var ClientUr $client_ur
         */
        $client_ur = ClientUr::find()->where('id=:id', [':id' => $id])->one();

        if (!is_object($client_ur)) {
            Yii::error('По данному идентификатору ни найдена организация, id' . serialize($id), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Организация ни найдена',
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

        $client_ur->status = $status;

        try {
            if (!$client_ur->save(false)) {
                Yii::error('Ошибка при обновлении статуса юр. клиента: ' . serialize($client_ur->getErrors()), __METHOD__);
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
     * @return bool|array
     */
    public static function GetClientUr()
    {
        Yii::info('Запуск функции GetClientUr', __METHOD__);
        $result = [];

        /**
         * @var ClientUr $client_ur
         */
        $client_ur = ClientUr::find()->orderBy('last_contact desc')->all();

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
}