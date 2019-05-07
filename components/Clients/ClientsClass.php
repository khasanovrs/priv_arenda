<?php
/**
 * Управление клиентами
 */

namespace app\components\Clients;

use app\models\ClientUr;
use app\models\Users;
use Yii;

class ClientsClass
{

    /**
     * Изменение параметров пользователя кроме пароля
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
     * Измененение пароля пользователя
     * @param $id ,
     * @param $pass ,
     * @return bool|array
     */
    public static function ChangeUserPass($id, $pass)
    {
        Yii::info('Запуск функции измененения пароля пользователя', __METHOD__);

        if ($id === '') {
            Yii::error('Ни передан идентификатор пользователя, id:' . serialize($id), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при проверке пользователя',
            ];
        }

        if ($pass === '') {
            Yii::error('Ошибка при проверке пароля, password:' . serialize($pass), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при проверке пароля',
            ];
        }

        /**
         * @var Users $user
         */
        $user = Users::find()->where('id=:id', [':id' => $id])->one();

        if (!is_object($user)) {
            Yii::error('Пользователь ни найден, id:' . serialize($id), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Пользователь ни найден',
            ];
        }

        $user->password = $pass;

        try {
            if (!$user->save(false)) {
                Yii::error('Ошибка при обновлении пароля пользователя: ' . serialize($user->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при обновлении пароля пользователя: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        Yii::info('Пароль успешно обновлен', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Пароль успешно обновлен'
        ];
    }
}