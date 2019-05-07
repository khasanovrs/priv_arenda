<?php
/**
 * Управление пользователем
 */

namespace app\components\Users;

use app\models\Users;
use Yii;

class MibUserClass
{

    /**
     * Изменение параметров пользователя кроме пароля
     * @param $id ,
     * @param $phone ,
     * @param $fio ,
     * @param $status ,
     * @param $email ,
     * @param $user_type
     * @return bool|array
     */
    public static function ChangeUserParams($id, $phone, $fio, $status, $email, $user_type)
    {
        Yii::info('Запуск функции обновления персональных данных пользователя', __METHOD__);

        if ($id === '') {
            Yii::error('Ни передан идентификатор пользователя, id:' . serialize($id), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при проверке пользователя',
            ];
        }

        if ($phone === '' || strlen($phone) !== 11) {
            Yii::error('Ошибка при проверке номера телефона, phone:' . serialize($phone), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при проверке номера телефона'
            ];
        }

        if ($fio === '') {
            Yii::error('Ошибка при проверке фио, fio:' . serialize($fio), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при проверке фио',
            ];
        }

        if ($status === '') {
            Yii::error('Передан некорректный статус, status:' . serialize($status), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Передан некорректный статус',
            ];
        }

        if ($email === '' || !preg_match("/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i", $email)) {
            Yii::error('Передан некорректный email, email:' . serialize($email), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Передан некорректный email',
            ];
        }

        if ($user_type === '') {
            Yii::error('Передан некорректный тип роли, user_type:' . serialize($user_type), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Передан некорректный тип роли',
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

        $user->telephone = $phone;
        $user->fio = $fio;
        $user->status = $status;
        $user->status = $email;
        $user->status = $user_type;

        try {
            if (!$user->save(false)) {
                Yii::error('Ошибка при обновлении персональных данных пользователя: ' . serialize($user->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при обновлении персональных данных пользователя: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        Yii::info('Персональные данные успешно обновлены', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Данные успешно обновлены'
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