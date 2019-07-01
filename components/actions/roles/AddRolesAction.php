<?php
/**
 * Добавление ролей
 */

namespace app\components\actions\branch;

use app\components\userRoles\UserRolesClass;
use Yii;
use yii\base\Action;

class AddRolesAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции добавления ролей', __METHOD__);

        $request = Yii::$app->request;

        $role = $request->getBodyParam('role');

        $resultChange = UserRolesClass::AddRole($role);

        if (!is_array($resultChange) || !isset($resultChange['status']) || $resultChange['status'] != 'SUCCESS') {
            Yii::error('Ошибка при добавлении новой роли', __METHOD__);

            if (is_array($resultChange) && isset($resultChange['status']) && $resultChange['status'] === 'SUCCESS') {
                return $resultChange;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при добавлении новой роли',
            ];
        }

        Yii::info('Роль успешно добавлена', __METHOD__);

        return [
            'status' => 'ОК',
            'msg' => 'Роль успешно добавлена',
        ];
    }
}