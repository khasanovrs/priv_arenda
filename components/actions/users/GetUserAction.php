<?php
/**
 * Получение пользователей по филиалам
 */

namespace app\components\actions\users;

use app\components\Users\UserClass;
use Yii;
use yii\base\Action;

class GetUserAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции получения пользователей', __METHOD__);

        $request = Yii::$app->request;

        $branch = $request->getBodyParam('branch');

        $resultChange = UserClass::GetUsers($branch);

        if (!is_array($resultChange) || !isset($resultChange['status']) || $resultChange['status'] != 'SUCCESS') {
            Yii::error('Ошибка при получении списка пользователей', __METHOD__);

            if (is_array($resultChange) && isset($resultChange['status']) && $resultChange['status'] === 'ERROR') {
                return $resultChange;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при получении списка пользователей',
            ];
        }

        Yii::info('Список пользователей получен', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Список пользователей получен',
            'data' => $resultChange['data']
        ];
    }
}