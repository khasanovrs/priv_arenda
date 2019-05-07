<?php
/**
 * Добавление пользователя
 */

namespace app\components\actions\login;

use app\components\Users\UserClass;
use Yii;
use yii\base\Action;

class AddUserAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции добавления пользователя', __METHOD__);

        $request = Yii::$app->request;

        $phone = $request->getBodyParam('phone');
        $password = $request->getBodyParam('password');
        $fio = $request->getBodyParam('fio');
        $status = $request->getBodyParam('status');
        $email = $request->getBodyParam('email');
        $user_type = $request->getBodyParam('user_type');
        $branch_id = $request->getBodyParam('branch_id');

        $resultChange = UserClass::AddUser($phone, $fio, $status, $email, $user_type, $password, $branch_id);

        if (!is_array($resultChange) || !isset($resultChange['status']) || $resultChange['status'] != 'SUCCESS') {
            Yii::error('Ошибка при добавлении нового пользователя', __METHOD__);

            if (is_array($resultChange) && isset($resultChange['status']) && $resultChange['status'] === 'ERROR') {
                return $resultChange;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при добавлении нового пользователя',
            ];
        }

        Yii::info('Новый пользователь успешно добавлен', __METHOD__);

        return [
            'status' => 'ОК',
            'msg' => 'Новый пользователь успешно добавлен',
        ];
    }
}