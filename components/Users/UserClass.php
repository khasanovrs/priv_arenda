<?php
/**
 * Управление пользователем
 */

namespace app\components\Users;

use app\components\Session\Sessions;
use app\models\Branch;
use app\models\BunchUserRight;
use app\models\Users;
use app\models\UsersRole;
use Yii;
use yii\debug\models\search\User;

class UserClass
{

    /**
     * Добавление нового пользователя
     * @param id
     * @param $phone
     * @param $fio
     * @param $email
     * @param $user_type
     * @param $pass
     * @param $branch_id
     * @param $user_right
     * @return bool|array
     */
    public static function AddUser($id, $phone, $fio, $email, $user_type, $pass, $branch_id, $user_right)
    {
        Yii::info('Запуск функции обновления персональных данных пользователя', __METHOD__);

        if (strlen($phone) !== 11) {
            Yii::error('Ошибка при проверке номера телефона, phone:' . serialize($phone), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при проверке номера телефона'
            ];
        }

        if ($fio === '') {
            Yii::error('Ошибка при проверке name, fio:' . serialize($fio), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при проверке фио',
            ];
        }

        if ($pass === '' && $id !== null) {
            Yii::error('Не передан пароль для пользователя, pass:' . serialize($pass), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не передан пароль для пользователя',
            ];
        }

        if ($email != '' && !preg_match("/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i", $email)) {
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

        Yii::info('Проверка номера телефона на уникальность', __METHOD__);

        /**
         * @var Users $check_user
         */
        $check_user = Users::find()->where('telephone=:telephone', [':telephone' => $phone])->one();

        if (is_object($check_user) && $check_user->id !== $id) {
            Yii::error('Данный номер телефона уже зарегестрирован, phone:' . serialize($phone), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Данный номер телефона уже зарегестрирован',
            ];
        }

        if ($id !== null) {
            $user = Users::find()->where('id=:id', [':id' => $id])->one();

            if (!is_object($user)) {

                Yii::error('Пользователь с таким идентификатором не найден, id:' . serialize($id), __METHOD__);
                return [
                    'status' => 'ERROR',
                    'msg' => 'Пользователь не найден',
                ];
            }
        } else {
            $user = new Users();
        }

        $user->fio = $fio;
        $user->telephone = $phone;
        $user->user_type = $user_type;
        $user->email = $email;
        $user->branch_id = $branch_id;

        if ($id === null) {
            $user->password = password_hash($pass, PASSWORD_DEFAULT);
        }

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

        Yii::info('Проверяем права для пользователя', __METHOD__);

        try {
            BunchUserRight::deleteAll('user_id=:user_id', [':user_id' => $user->id]);
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при удалении прав пользователя: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        if (!empty($user_right)) {
            Yii::info('Есть специальные права для пользователя', __METHOD__);

            foreach ($user_right as $value) {
                $newRight = new BunchUserRight();
                $newRight->user_id = $user->id;
                $newRight->right_id = $value;

                try {
                    if (!$newRight->save(false)) {
                        Yii::error('Ошибка при добавлении прав для пользователя: ' . serialize($newRight->getErrors()), __METHOD__);
                        return false;
                    }
                } catch (\Exception $e) {
                    Yii::error('Поймали Exception при добавлении прав для пользователя: ' . serialize($e->getMessage()), __METHOD__);
                    return false;
                }
            }
        }

        Yii::info('Пользователь успешно добавлен', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Пользователь успешно добавлен'
        ];
    }

    /**
     * Изменение параметров пользователя кроме пароля
     * @param $id
     * @param $phone
     * @param $fio
     * @param $status
     * @param $email
     * @param $user_type
     * @param $branch_id
     * @return bool|array
     */
    public static function ChangeUserParams($id, $phone, $fio, $status, $email, $user_type, $branch_id)
    {
        Yii::info('Запуск функции обновления персональных данных пользователя', __METHOD__);

        if ($id === '') {
            Yii::error('Не передан идентификатор пользователя, id:' . serialize($id), __METHOD__);

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
            Yii::error('Пользователь не найден, id:' . serialize($id), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Пользователь не найден',
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
     * @param $id
     * @param $pass
     * @return bool|array
     */
    public static function ChangeUserPass($id, $pass)
    {
        Yii::info('Запуск функции измененения пароля пользователя', __METHOD__);

        if ($id === '') {
            Yii::error('Не передан идентификатор пользователя, id:' . serialize($id), __METHOD__);

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
            Yii::error('Пользователь не найден, id:' . serialize($id), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Пользователь не найден',
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

    /**
     * Получение списка пользователей
     * @param $branch
     * @return bool|array
     */
    public static function GetUsers($branch)
    {
        Yii::info('Запуск функции GetUsers', __METHOD__);

        $result = [];

        if ($branch === '' || !is_int($branch)) {
            Yii::error('Не передан идентификатор филиала, branch:' . serialize($branch), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Передан некорректный идентификатор филиала',
            ];
        }

        $users = Users::find()->where('branch_id=:branch_id', [':branch_id' => $branch])->all();

        if (empty($users)) {
            Yii::info('Пользователей нет', __METHOD__);

            return [
                'status' => 'SUCCESS',
                'msg' => 'Пользователей нет',
                'data' => $result
            ];
        }

        /**
         * @var Users $user
         */
        foreach ($users as $user) {
            $rights = [];

            $rightsList = BunchUserRight::find()->where('user_id=:user_id', [':user_id' => $user->id])->all();

            if (!empty($rightsList)) {
                /**
                 * @var BunchUserRight $value
                 */
                foreach ($rightsList as $value) {
                    array_push($rights, $value->right_id);
                }
            }

            $result[] = [
                'id' => $user->id,
                'fio' => $user->fio,
                'phone' => $user->telephone,
                'status' => $user->status,
                'user_type' => $user->user_type,
                'email' => $user->email,
                'branch_id' => $user->branch_id,
                'date_create' => date('d.m.Y h:i:s', strtotime($user->date_create)),
                'rights' => $rights
            ];
        }

        Yii::info('Пользователи успешно получены', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Пользователи успешно получены',
            'data' => $result
        ];
    }

    /**
     * Получение информации по авторизованному пользователю
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public static function GetUserInfo()
    {
        Yii::info('Запуск функции получении информации по авторизованному пользователю', __METHOD__);

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
         * @var Users $user
         */
        $user = Users::find()->where('id=:id', [':id' => $session->user_id])->one();

        if (!is_object($user)) {
            Yii::error('Пользователь не найден', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Пользователь не найден',
            ];
        }

        Yii::info('Пользователь найден', __METHOD__);

        $result = [
            'branch' => $user->branch_id,
            'type' => $user->user_type
        ];


        return [
            'status' => 'SUCCESS',
            'msg' => 'Пользователи успешно получены',
            'data' => $result
        ];
    }
}