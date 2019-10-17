<?php
/**
 * Получение информации по авторизованному пользователю
 */

namespace app\components\actions\users;

use app\components\Users\UserClass;
use Yii;
use yii\base\Action;

class GetAuthUserAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции получения информации по авторизованному пользователю', __METHOD__);

        $resultChange = UserClass::GetUserInfo();

        if (!is_array($resultChange) || !isset($resultChange['status']) || $resultChange['status'] != 'SUCCESS') {
            Yii::error('Ошибка при получении информации по авторизованному пользователю', __METHOD__);

            if (is_array($resultChange) && isset($resultChange['status']) && $resultChange['status'] === 'ERROR') {
                return $resultChange;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при получении информации по авторизованному пользователю',
            ];
        }

        Yii::info('Информация по авторизованному пользователю получен успешно', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Информация по авторизованному пользователю получен успешно',
            'data' => $resultChange['data']
        ];
    }
}