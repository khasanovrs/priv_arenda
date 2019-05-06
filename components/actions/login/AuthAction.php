<?php
/**
 * Авторизация пользователя
 */

namespace app\components\actions\login;

use app\models\Users;
use Yii;
use yii\base\Action;

class AuthAction extends Action
{
    public function run()
    {
        Yii::info('Запуск авторизации пользователя', __METHOD__);

        $request = Yii::$app->request;

        $phone = $request->getBodyParam('phone');
        $password = $request->getBodyParam('password');

        if ($phone === '' || strlen($phone) !== 11) {
            Yii::error('Ошибка при проверке номера телефона, phone:' . serialize($phone), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при проверке номера телефона'
            ];
        }

        if ($password === '') {
            Yii::error('Ошибка при проверке пароля, password:' . serialize($password), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при проверке пароля',
            ];
        }

        /**
         * @var Users $user
         */
        $user = Users::find()->where('telephone=:telephone', [':telephone' => $phone])->one();

        if (!is_object($user)) {
            Yii::error('Пользователь с таким номером телефона ни найден, phone:' . serialize($phone), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Пользователь с таким номером телефона ни найден',
            ];
        }

        if (!password_verify($password, $user->password)) {
            Yii::error('Пароль не прошел проверку!', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Неверный номер телефона или пароль',
            ];
        }

        Yii::info('Авторизация прошла успешно', __METHOD__);
        //@todo запись сессии, token

        return [
            'status' => 'OK',
            'msg' => 'Успешная авторизация'
        ];
    }
}