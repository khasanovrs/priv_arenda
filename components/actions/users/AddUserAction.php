<?php
/**
 * Добавление пользователя
 */

namespace app\components\actions\users;

use app\components\Users\UserClass;
use Yii;
use yii\base\Action;

class AddUserAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции добавления пользователя', __METHOD__);

        $request = Yii::$app->request;

        $name = $request->getBodyParam('name');
        $lastName = $request->getBodyParam('lastName');
        $password = $request->getBodyParam('password');
        $user_type = $request->getBodyParam('user_type');
        $branch_id = $request->getBodyParam('branch_id');
        $email = $request->getBodyParam('email');
        $phone = $request->getBodyParam('phone');
        $user_right = $request->getBodyParam('user_right');

        $resultChange = UserClass::AddUser($phone, $name, $lastName, $email, $user_type, $password, $branch_id, $user_right);

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
            'status' => 'OK',
            'msg' => 'Новый пользователь успешно добавлен',
        ];
    }
}