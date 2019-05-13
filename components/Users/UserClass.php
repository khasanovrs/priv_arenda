<?php
/**
 * Управление пользователем
 */

namespace app\components\Users;

use app\models\Branch;
use app\models\Users;
use app\models\UsersRole;
use Yii;

class UserClass
{

    /**
     * Добавление нового пользователя
     * @param $phone ,
     * @param $fio ,
     * @param $status ,
     * @param $email ,
     * @param $user_type
     * @param $pass
     * @param $branch_id
     * @return bool|array
     */
    public static function AddUser($phone, $fio, $status, $email, $user_type, $pass, $branch_id)
    {
        Yii::info('Запуск функции обновления персональных данных пользователя', __METHOD__);

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

        if ($pass === '') {
            Yii::error('Не передан пароль для пользователя, pass:' . serialize($pass), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не передан пароль для пользователя',
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

        if ($branch_id === '') {
            Yii::error('Передан некорректный идентификтор филиала, branch_id:' . serialize($branch_id), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Передан некорректный идентификтор филиала',
            ];
        }

        $check_role = UsersRole::find()->where('id=:id', [':id' => $user_type])->one();

        if (!is_object($check_role)) {
            Yii::error('Передан некорректный идентификтор роли, user_type:' . serialize($user_type), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Указанная роль не существует',
            ];
        }

        $check_branch = Branch::find()->where('id=:id', [':id' => $branch_id])->one();

        if (!is_object($check_branch)) {
            Yii::error('Передан некорректный идентификтор филиала, branch_id:' . serialize($branch_id), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Указанный филиал не существует',
            ];
        }

        $user = new Users();
        $user->fio = $fio;
        $user->telephone = $phone;
        $user->status = $status;
        $user->user_type = $user_type;
        $user->email = $email;
        $user->branch_id = $branch_id;
        $user->password = password_hash($pass, PASSWORD_DEFAULT);
        $user->date_create = date('Y-m-d H:i:s');
        $user->date_update = date('Y-m-d H:i:s');

        try {
            if (!$user->save(false)) {
                Yii::error('Ошибка при добавлении нового пользователя: ' . serialize($user->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при добавлении нового пользователя: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        Yii::info('Пользователь успешно добавлен', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Пользователь успешно добавлен'
        ];
    }

    /**
     * Изменение параметров пользователя кроме пароля
     * @param $id ,
     * @param $phone ,
     * @param $fio ,
     * @param $status ,
     * @param $email ,
     * @param $user_type ,
     * @param $branch_id
     * @return bool|array
     */
    public static function ChangeUserParams($id, $phone, $fio, $status, $email, $user_type, $branch_id)
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

        if ($branch_id === '') {
            Yii::error('Передан некорректный идентификтор филиала, branch_id:' . serialize($branch_id), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Передан некорректный идентификтор филиала',
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

        $check_role = UsersRole::find()->where('id=:id', [':id' => $user_type])->one();

        if (!is_object($check_role)) {
            Yii::error('Передан некорректный идентификтор роли, user_type:' . serialize($user_type), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Указанная роль не существует',
            ];
        }

        $check_branch = Branch::find()->where('id=:id', [':id' => $branch_id])->one();

        if (!is_object($check_branch)) {
            Yii::error('Передан некорректный идентификтор филиала, branch_id:' . serialize($branch_id), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Указанный филиал не существует',
            ];
        }

        $user->fio = $fio;
        $user->telephone = $phone;
        $user->status = $status;
        $user->user_type = $user_type;
        $user->email = $email;
        $user->branch_id = $branch_id;
        $user->date_update = date('Y-m-d H:i:s');

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

        $user->password = hash('sha256', $pass);

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