<?php
/**
 * Управление клиентами
 */

namespace app\components\Clients;

use app\models\Branch;
use app\models\ClientFiz;
use app\models\ClientFizInfo;
use app\models\ClientSource;
use app\models\ClientStatus;
use app\models\ClientUr;
use app\models\ClientUrInfo;
use app\models\Discount;
use app\models\ShowFieldClient;
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
     * @return bool|array
     */
    public static function AddClient($sale, $branch, $status, $source, $name, $inn, $occupation, $address, $ogrn, $bic, $kpp, $schet, $name_chief, $phone_chief, $phone, $phone_2)
    {
        Yii::info('Запуск функции добавления клиента', __METHOD__);

        if ($sale === '') {
            Yii::error('Ни передано значение скидки, sale: ' . serialize($sale), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не передано значение скидки',
            ];
        }

        if ($branch === '') {
            Yii::error('Ни передан идентификатор филиала, branch: ' . serialize($branch), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не передан идентификатор филиала'
            ];
        }

        if ($status === '') {
            Yii::error('Ни передан идентификатор статуса, status: ' . serialize($status), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не передан идентификатор статуса',
            ];
        }

        if ($source === '') {
            Yii::error('Ни передан идентификатор источника, source: ' . serialize($source), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не передан идентификатор источника',
            ];
        }

        if ($phone_chief === '' && $phone === '' && $phone_2 === '') {
            Yii::error('Ни передан номер телефона', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ни передан номер телефона',
            ];
        } else if (($phone_chief !== '' && strlen($phone_chief) !== 11) || ($phone !== '' && strlen($phone) !== 11) || ($phone_2 !== '' && strlen($phone_2) !== 11)) {
            Yii::error('Указан некорректный номер телефона', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Указан некорректный номер телефона',
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

        $check_source = ClientSource::find()->where('id=:id', [':id' => $source])->one();

        if (!is_object($check_source)) {
            Yii::error('Передан некорректный исчтоник, :' . serialize($source), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Передан некорректный исчтоник',
            ];
        }

        Yii::info('Добавляем нового клиента', __METHOD__);

        if ($name !== '') {
            Yii::info('Заводим клиента как юр. лицо', __METHOD__);

            $check_phone = ClientUr::find()->where('phone=:phone', [':phone' => $phone])->one();

            if (is_object($check_phone)) {
                Yii::error('Клиент с данным номер телефона уже зарегестрирован, phone:' . serialize($phone), __METHOD__);

                return [
                    'status' => 'ERROR',
                    'msg' => 'Клиент с данным номер телефона уже зарегестрирован',
                ];
            }

            $newClientUr = new ClientUr();
            $newClientUr->name_org = $name;
            $newClientUr->phone = $phone;
            $newClientUr->status = $status;
            $newClientUr->branch_id = $branch;
            $newClientUr->last_contact = date('Y-m-d H:i:s');
            $newClientUr->date_create = date('Y-m-d H:i:s');

            try {
                if (!$newClientUr->save(false)) {
                    Yii::error('Ошибка при добавлении юр. клиента: ' . serialize($newClientUr->getErrors()), __METHOD__);
                    return false;
                }
            } catch (\Exception $e) {
                Yii::error('Поймали Exception при добавлении юр. клиента: ' . serialize($e->getMessage()), __METHOD__);
                return false;
            }

            /**
             * @var ClientUr $client
             */
            $client = ClientUr::find()->where('phone=:phone', [':phone' => $phone])->one();

            if (!is_object($client)) {
                Yii::error('Клиент с данным номер телефона ни найден, phone:' . serialize($phone), __METHOD__);

                return [
                    'status' => 'ERROR',
                    'msg' => 'Ошибка при сохранени нового клиента',
                ];
            }

            $newClientUrInfo = new ClientUrInfo();
            $newClientUrInfo->client_id = $client->id;
            $newClientUrInfo->source = $source;
            $newClientUrInfo->rentals = 0;
            $newClientUrInfo->dohod = 0;
            $newClientUrInfo->sale = $sale;
            $newClientUrInfo->address = $address;
            $newClientUrInfo->name_org = $name;
            $newClientUrInfo->inn = $inn;
            $newClientUrInfo->occupation = $occupation;
            $newClientUrInfo->ogrn = $ogrn;
            $newClientUrInfo->bic = $bic;
            $newClientUrInfo->kpp = $kpp;
            $newClientUrInfo->schet = $schet;
            $newClientUrInfo->name_chief = $name_chief;
            $newClientUrInfo->phone_chief = $phone_chief;
            $newClientUrInfo->phone_second = $phone_2;
            $newClientUrInfo->date_create = date('Y-m-d H:i:s');
            $newClientUrInfo->date_update = date('Y-m-d H:i:s');

            try {
                if (!$newClientUrInfo->save(false)) {
                    Yii::error('Ошибка при добавлении дополнительной информации о юр. клиенте: ' . serialize($newClientUrInfo->getErrors()), __METHOD__);
                    return false;
                }
            } catch (\Exception $e) {
                Yii::error('Поймали Exception при добавлении дополнительной информации о юр. клиенте: ' . serialize($e->getMessage()), __METHOD__);
                return false;
            }

        } else {
            if ($name_chief === '') {
                Yii::error('Необхродимо указать наименование организации или фио', __METHOD__);

                return [
                    'status' => 'ERROR',
                    'msg' => 'Необхродимо указать "наименование организации" или "фио клиента"',
                ];
            }

            Yii::info('Заводим клиента как физ. лицо', __METHOD__);

            $check_phone = ClientFiz::find()->where('phone=:phone', [':phone' => $phone])->one();

            if (is_object($check_phone)) {
                Yii::error('Клиент с данным номер телефона уже зарегестрирован, phone:' . serialize($phone), __METHOD__);

                return [
                    'status' => 'ERROR',
                    'msg' => 'Клиент с данным номер телефона уже зарегестрирован',
                ];
            }

            $newClientFiz = new ClientFiz();
            $newClientFiz->fio = $name_chief;
            $newClientFiz->phone = $phone;
            $newClientFiz->status = $status;
            $newClientFiz->branch_id = $branch;
            $newClientFiz->last_contact = date('Y-m-d H:i:s');
            $newClientFiz->date_create = date('Y-m-d H:i:s');

            try {
                if (!$newClientFiz->save(false)) {
                    Yii::error('Ошибка при добавлении физ. клиента: ' . serialize($newClientFiz->getErrors()), __METHOD__);
                    return false;
                }
            } catch (\Exception $e) {
                Yii::error('Поймали Exception при добавлении физ. клиента: ' . serialize($e->getMessage()), __METHOD__);
                return false;
            }

            /**
             * @var ClientFiz $client
             */
            $client = ClientFiz::find()->where('phone=:phone', [':phone' => $phone])->one();

            if (!is_object($client)) {
                Yii::error('Клиент с данным номер телефона ни найден, phone:' . serialize($phone), __METHOD__);

                return [
                    'status' => 'ERROR',
                    'msg' => 'Ошибка при сохранени нового клиента',
                ];
            }

            $newClientFizInfo = new ClientFizInfo();
            $newClientFizInfo->client_id = $client->id;
            $newClientFizInfo->source = $source;
            $newClientFizInfo->rentals = 0;
            $newClientFizInfo->dohod = 0;
            $newClientFizInfo->sale = $sale;
            $newClientFizInfo->phone_chief = $phone_chief;
            $newClientFizInfo->phone_second = $phone_2;
            $newClientFizInfo->date_create = date('Y-m-d H:i:s');
            $newClientFizInfo->date_update = date('Y-m-d H:i:s');

            try {
                if (!$newClientFizInfo->save(false)) {
                    Yii::error('Ошибка при добавлении дополнительной информации о физ. клиенте: ' . serialize($newClientFizInfo->getErrors()), __METHOD__);
                    return false;
                }
            } catch (\Exception $e) {
                Yii::error('Поймали Exception при добавлении дополнительной информации о физ. клиенте: ' . serialize($e->getMessage()), __METHOD__);
                return false;
            }
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
     * @param $clientType ,
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
     * @return bool|array
     */
    public static function UpdateClientInfo($clientId, $clientType, $sale, $branch, $status, $source, $name, $inn, $occupation, $address, $ogrn, $bic, $kpp, $schet, $name_chief, $phone_chief, $phone, $phone_2)
    {
        Yii::info('Запуск функции изменений детальной информации клиента', __METHOD__);

        if ($clientId === '') {
            Yii::error('Некорректный идентификатор клиента', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Некорректный идентификатор клиента'
            ];
        }

        if ($clientType === '' || ($clientType !== 'fiz' && $clientType !== 'ur')) {
            Yii::error('Некорректный тип клиента', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Некорректный тип клиента'
            ];
        }

        if ($sale === '') {
            Yii::error('Ни передано значение скидки, sale: ' . serialize($sale), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не передано значение скидки',
            ];
        }

        if ($branch === '') {
            Yii::error('Ни передан идентификатор филиала, branch: ' . serialize($branch), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не передан идентификатор филиала'
            ];
        }

        if ($status === '') {
            Yii::error('Ни передан идентификатор статуса, status: ' . serialize($status), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не передан идентификатор статуса',
            ];
        }

        if ($source === '') {
            Yii::error('Ни передан идентификатор источника, source: ' . serialize($source), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не передан идентификатор источника',
            ];
        }

        if ($phone_chief === '' && $phone === '' && $phone_2 === '') {
            Yii::error('Ни передан номер телефона', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ни передан номер телефона',
            ];
        } else if (($phone_chief !== '' && strlen($phone_chief) !== 11) || ($phone !== '' && strlen($phone) !== 11) || ($phone_2 !== '' && strlen($phone_2) !== 11)) {
            Yii::error('Указан некорректный номер телефона', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Указан некорректный номер телефона',
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

        $check_source = ClientSource::find()->where('id=:id', [':id' => $source])->one();

        if (!is_object($check_source)) {
            Yii::error('Передан некорректный исчтоник, :' . serialize($source), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Передан некорректный исчтоник',
            ];
        }

        Yii::info('Обновление информациии о клиенте', __METHOD__);

        if ($clientType === 'ur') {
            Yii::info('Обновляем информацию юридического клиента', __METHOD__);

            /**
             * @var ClientUr $newClientUr
             */
            $newClientUr = ClientUr::find()->where('id=:id', [':id' => $clientId])->one();

            if (!is_object($newClientUr)) {
                Yii::error('Клиент ни найден, id:' . serialize($clientId), __METHOD__);

                return [
                    'status' => 'ERROR',
                    'msg' => 'Клиент не найден',
                ];
            }

            $newClientUr->name_org = $name;
            $newClientUr->phone = $phone;
            $newClientUr->status = $status;
            $newClientUr->branch_id = $branch;

            try {
                if (!$newClientUr->save(false)) {
                    Yii::error('Ошибка при добавлении юр. клиента: ' . serialize($newClientUr->getErrors()), __METHOD__);
                    return false;
                }
            } catch (\Exception $e) {
                Yii::error('Поймали Exception при добавлении юр. клиента: ' . serialize($e->getMessage()), __METHOD__);
                return false;
            }

            /**
             * @var ClientUrInfo $newClientUrInfo
             */
            $newClientUrInfo = ClientUrInfo::find()->where('client_id=:client_id', [':client_id' => $clientId])->one();

            if (!is_object($newClientUrInfo)) {
                Yii::error('Запись ни найдена, client_id:' . serialize($clientId), __METHOD__);

                return [
                    'status' => 'ERROR',
                    'msg' => 'Клиент не найден',
                ];
            }

            $newClientUrInfo->source = $source;
            $newClientUrInfo->sale = $sale;
            $newClientUrInfo->address = $address;
            $newClientUrInfo->name_org = $name;
            $newClientUrInfo->inn = $inn;
            $newClientUrInfo->occupation = $occupation;
            $newClientUrInfo->ogrn = $ogrn;
            $newClientUrInfo->bic = $bic;
            $newClientUrInfo->kpp = $kpp;
            $newClientUrInfo->schet = $schet;
            $newClientUrInfo->name_chief = $name_chief;
            $newClientUrInfo->phone_chief = $phone_chief;
            $newClientUrInfo->phone_second = $phone_2;
            $newClientUrInfo->date_update = date('Y-m-d H:i:s');

            try {
                if (!$newClientUrInfo->save(false)) {
                    Yii::error('Ошибка при обновлении дополнительной информации о юр. клиенте: ' . serialize($newClientUrInfo->getErrors()), __METHOD__);
                    return false;
                }
            } catch (\Exception $e) {
                Yii::error('Поймали Exception при обновлении дополнительной информации о юр. клиенте: ' . serialize($e->getMessage()), __METHOD__);
                return false;
            }

        } else {
            if ($name_chief === '') {
                Yii::error('Необходимо указать наименование организации или фио', __METHOD__);

                return [
                    'status' => 'ERROR',
                    'msg' => 'Необхродимо указать "наименование организации" или "фио клиента"',
                ];
            }

            Yii::info('Заводим клиента как физ. лицо', __METHOD__);

            /**
             * @var ClientFiz $newClientFiz
             */
            $newClientFiz = ClientFiz::find()->where('id=:id', [':id' => $clientId])->one();

            if (!is_object($newClientFiz)) {
                Yii::error('Клиент ни найден, id:' . serialize($clientId), __METHOD__);

                return [
                    'status' => 'ERROR',
                    'msg' => 'Клиент не найден',
                ];
            }

            $newClientFiz->fio = $name_chief;
            $newClientFiz->phone = $phone;
            $newClientFiz->status = $status;
            $newClientFiz->branch_id = $branch;

            try {
                if (!$newClientFiz->save(false)) {
                    Yii::error('Ошибка при обновлении информации о  физ. клиенте: ' . serialize($newClientFiz->getErrors()), __METHOD__);
                    return false;
                }
            } catch (\Exception $e) {
                Yii::error('Поймали Exception при обновлении информации о  физ. клиенте: ' . serialize($e->getMessage()), __METHOD__);
                return false;
            }

            /**
             * @var ClientFizInfo $newClientFizInfo
             */
            $newClientFizInfo = ClientFizInfo::find()->where('client_id=:client_id', [':client_id' => $clientId])->one();

            if (!is_object($newClientFizInfo)) {
                Yii::error('Запись ни найдена, client_id:' . serialize($clientId), __METHOD__);

                return [
                    'status' => 'ERROR',
                    'msg' => 'Клиент не найден',
                ];
            }

            $newClientFizInfo->source = $source;
            $newClientFizInfo->sale = $sale;
            $newClientFizInfo->phone_chief = $phone_chief;
            $newClientFizInfo->phone_second = $phone_2;
            $newClientFizInfo->date_update = date('Y-m-d H:i:s');

            try {
                if (!$newClientFizInfo->save(false)) {
                    Yii::error('Ошибка при обновлении дополнительной информации о физ. клиенте: ' . serialize($newClientFizInfo->getErrors()), __METHOD__);
                    return false;
                }
            } catch (\Exception $e) {
                Yii::error('Поймали Exception при обновлении дополнительной информации о физ. клиенте: ' . serialize($e->getMessage()), __METHOD__);
                return false;
            }
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

        $listUr = [];
        $listFiz = [];
        $params = [];
        $resultUr = [];
        $resultFiz = [];

        if ($like !== '' and $like !== null) {
            Yii::info('Параметр like: ' . serialize($like), __METHOD__);
            $like = '%' . $like . '%';
            $listUr[] = 'name_org like :like';
            $listFiz[] = 'fio like :like';
            $params[':like'] = $like;
        }

        if ($branch !== '' and $branch !== null) {
            Yii::info('Параметр branch: ' . serialize($branch), __METHOD__);
            $listFiz[] = $listUr[] = 'branch_id=:branch';
            $params[':branch'] = $branch;
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

        if ($type === 'all' || $type === 'ur') {
            if (!empty($listUr)) {
                $client_ur = ClientUr::find()->with('clientUrInfos')->where(implode(" and ", $listUr), $params)->orderBy('last_contact desc')->all();
            } else {
                $client_ur = ClientUr::find()->with('clientUrInfos')->orderBy('last_contact desc')->all();
            }

            if (is_array($client_ur)) {
                /**
                 * @var ClientUr $value
                 */
                foreach ($client_ur as $value) {
                    $sourceBD = $value->clientUrInfos[0]->source0;
                    $discount = $value->clientUrInfos[0]->sale0;
                    $rentalsBD = $value->clientUrInfos[0]->rentals;
                    $dohodBD = $value->clientUrInfos[0]->dohod;

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

                    $resultUr[] = [
                        'id' => $value->id,
                        'fio' => '',
                        'org' => $value->name_org,
                        'phone' => $value->phone,
                        'status' => $value->status,
                        'date_create' => date('d.m.Y', strtotime($value->date_create)),
                        'last_contact' => date('d.m.Y', strtotime($value->last_contact)),
                        'source' => ['id' => $sourceBD->id, 'name' => $sourceBD->name],
                        'rentals' => $rentalsBD,
                        'dohod' => $dohodBD,
                        'sale' => ['code' => $discount->code, 'name' => $discount->name],
                        'type' => 'ur'
                    ];
                }
            }
        }

        if ($type === 'all' || $type === 'fiz') {
            if (!empty($listFiz)) {
                $client_fiz = ClientFiz::find()->with('clientFizInfos')->where(implode(" and ", $listFiz), $params)->orderBy('last_contact desc')->all();
            } else {
                $client_fiz = ClientFiz::find()->with('clientFizInfos')->orderBy('last_contact desc')->all();
            }

            if (is_array($client_fiz)) {
                /**
                 * @var ClientFiz $value
                 */
                foreach ($client_fiz as $value) {
                    $sourceBD = $value->clientFizInfos[0]->source0;
                    $discount = $value->clientFizInfos[0]->sale0;
                    $rentalsBD = $value->clientFizInfos[0]->rentals;
                    $dohodBD = $value->clientFizInfos[0]->dohod;

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

                    $resultFiz[] = [
                        'id' => $value->id,
                        'fio' => $value->fio,
                        'phone' => $value->phone,
                        'status' => $value->status,
                        'date_create' => date('d.m.Y', strtotime($value->date_create)),
                        'last_contact' => date('d.m.Y', strtotime($value->last_contact)),
                        'source' => ['id' => $sourceBD->id, 'name' => $sourceBD->name],
                        'rentals' => $rentalsBD,
                        'dohod' => $dohodBD,
                        'sale' => ['code' => $discount->code, 'name' => $discount->name],
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
        Yii::info('Запуск функции ChangeFields' . serialize($params), __METHOD__);

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

    /**
     * Получение детальной информации по клиенту
     * @param $clientId
     * @param $clientType
     * @return bool|array
     */
    public static function GetDetailInfoClient($clientId, $clientType)
    {
        Yii::info('Запуск функции GetDetailInfoClient', __METHOD__);

        if ($clientId === '') {
            Yii::error('Некорректный идентификатор клиента', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Некорректный идентификатор клиента'
            ];
        }

        if ($clientType === '' || ($clientType !== 'fiz' && $clientType !== 'ur')) {
            Yii::error('Некорректный тип клиента', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Некорректный тип клиента'
            ];
        }

        if ($clientType === 'ur') {

            /**
             * @var ClientUr $client_ur
             */
            $client_ur = ClientUr::find()->where('id=:id', [':id' => $clientId])->one();

            if (!is_object($client_ur)) {
                Yii::error('Клиент с таким идентификатором ни найден, id: ' . serialize($clientId), __METHOD__);

                return [
                    'status' => 'ERROR',
                    'msg' => 'Клиент с таким идентификатором ни найден'
                ];
            }

            $sourceBD = $client_ur->clientUrInfos[0]->source0;
            $discount = $client_ur->clientUrInfos[0]->sale0;
            $branch = $client_ur->branch;
            $status = $client_ur->status0;

            $result = [
                'id' => $client_ur->id,
                'sale' => $discount->id,
                'branch' => $branch->id,
                'status' => $status->id,
                'source' => $sourceBD->id,
                'org' => $client_ur->name_org,
                'inn' => $client_ur->clientUrInfos[0]->inn,
                'occupation' => $client_ur->clientUrInfos[0]->occupation,
                'address' => $client_ur->clientUrInfos[0]->address,
                'ogrn' => $client_ur->clientUrInfos[0]->ogrn,
                'bic' => $client_ur->clientUrInfos[0]->bic,
                'kpp' => $client_ur->clientUrInfos[0]->kpp,
                'schet' => $client_ur->clientUrInfos[0]->schet,
                'name_chief' => $client_ur->clientUrInfos[0]->name_chief,
                'phone_chief' => $client_ur->clientUrInfos[0]->phone_chief,
                'phone_2' => $client_ur->clientUrInfos[0]->phone_second,
                'phone' => $client_ur->phone,
            ];

        } else {
            /**
             * @var ClientFiz $client_fiz
             */
            $client_fiz = ClientFiz::find()->where('id=:id', [':id' => $clientId])->one();

            if (!is_object($client_fiz)) {
                Yii::error('Клиент с таким идентификатором ни найден, id: ' . serialize($clientId), __METHOD__);

                return [
                    'status' => 'ERROR',
                    'msg' => 'Клиент с таким идентификатором ни найден'
                ];
            }

            $sourceBD = $client_fiz->clientFizInfos[0]->source0;
            $discount = $client_fiz->clientFizInfos[0]->sale0;
            $branch = $client_fiz->branch;
            $status = $client_fiz->status0;

            $result = [
                'id' => $client_fiz->id,
                'sale' => $discount->id,
                'branch' => $branch->id,
                'status' => $status->id,
                'source' => $sourceBD->id,
                'org' => '',
                'inn' => '',
                'occupation' => '',
                'address' => '',
                'ogrn' => '',
                'bic' => '',
                'kpp' => '',
                'schet' => '',
                'name_chief' => $client_fiz->fio,
                'phone_chief' => $client_fiz->clientFizInfos[0]->phone_chief,
                'phone_2' => $client_fiz->clientFizInfos[0]->phone_second,
                'phone' => $client_fiz->phone,
            ];
        }

        Yii::info('Информация по клиенту успешно получена', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Информация по клиенту успешно получена',
            'data' => $result
        ];
    }


}