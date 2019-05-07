<?php
/**
 * Редактирование пользователя
 */

namespace app\components\actions\login;

use app\components\Users\UserClass;
use Yii;
use yii\base\Action;

class ChangeUserAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции изменения данных пользователя', __METHOD__);

        $request = Yii::$app->request;

        $phone = $request->getBodyParam('phone');
        $password = $request->getBodyParam('password');
        $fio = $request->getBodyParam('fio');
        $status = $request->getBodyParam('status');
        $email = $request->getBodyParam('email');
        $user_type = $request->getBodyParam('user_type');
        $id = $request->getBodyParam('id');

        Yii::info('Обновляем персональные данные пользователя', __METHOD__);

        $resultChange = UserClass::ChangeUserParams($id, $phone, $fio, $status, $email, $user_type);

        if (!is_array($resultChange) || !isset($resultChange['status']) || $resultChange['status'] != 'SUCCESS') {
            Yii::error('Ошибка при обновлении персонльных данных пользователя', __METHOD__);

            if (is_array($resultChange) && isset($resultChange['status']) && $resultChange['status'] === 'ERROR') {
                return $resultChange;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при обновлении персонльных данных пользователя',
            ];
        }

        Yii::info('Обновляем пароль пользователя', __METHOD__);

        $resultChange = UserClass::ChangeUserPass($id, $password);

        if (!is_array($resultChange) || !isset($resultChange['status']) || $resultChange['status'] != 'SUCCESS') {
            Yii::error('Ошибка при обновлении пароля пользователя', __METHOD__);

            if (is_array($resultChange) && isset($resultChange['status']) && $resultChange['status'] === 'ERROR') {
                return $resultChange;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при обновлении пароля пользователя',
            ];
        }

        Yii::info('Данные пользователя успешно обновлены', __METHOD__);

        return [
            'status' => 'ОК',
            'msg' => 'Данные пользователя успешно обновлены',
        ];
    }
}