<?php
/**
 * Авторизация пользователя
 */

namespace app\components\actions\auth;

use app\components\Session\SessionClass;
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
                'msg' => 'Укажите корректный номер телефона'
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

        $resultSession = SessionClass::AddNewSession($user->id);

        if (!is_array($resultSession) || !isset($resultSession['status']) || $resultSession['status'] != 'SUCCESS') {
            Yii::error('Ошибка при установке активной сессии', __METHOD__);

            if (is_array($resultSession) && isset($resultSession['status']) && $resultSession['status'] === 'ERROR') {
                return $resultSession;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при установке сессии',
            ];
        }

        Yii::info('Авторизация прошла успешно', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Успешная авторизация',
            'data'=>['branch'=>$user->branch_id]
        ];
    }
}