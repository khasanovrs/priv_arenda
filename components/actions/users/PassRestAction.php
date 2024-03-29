<?php
/**
 * Смена пароля
 */

namespace app\components\actions\users;

use app\components\Users\UserClass;
use Yii;
use yii\base\Action;

class PassRestAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции смены пароля', __METHOD__);

        $request = Yii::$app->request;

        $id = $request->getBodyParam('id');
        $password = $request->getBodyParam('password');

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

        Yii::info('Пароль успешно изменен', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Пароль успешно изменен'
        ];
    }
}