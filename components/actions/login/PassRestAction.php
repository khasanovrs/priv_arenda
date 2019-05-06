<?php
/**
 * Смена пароля
 */

namespace app\components\actions\login;

use app\models\Users;
use Yii;
use yii\base\Action;

class PassRestAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции смены пароля', __METHOD__);

        $request = Yii::$app->request;

        $phone = $request->getBodyParam('phone');
        $password = $request->getBodyParam('password');

        if ($phone === '' || strlen($phone) !== 11) {
            Yii::error('Ошибка при проверке номера телефона, phone:' . serialize($phone), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при проверке номера телефона' . serialize($phone),
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

        try {
            $pass = hash('sha256', $password);

            Users::updateAll(['password' => $pass], 'telephone=:telephone', [':telephone' => $phone]);
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при обновлении пароля пользователя: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        Yii::info('Пароль успешно изменен', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Пароль успешно изменен'
        ];
    }
}