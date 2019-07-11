<?php
/**
 * Удаление скидки
 */

namespace app\components\actions\roles;

use app\components\discount\DiscountClass;
use app\components\userRoles\UserRolesClass;
use Yii;
use yii\base\Action;

class DeleteRolesAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции удаления скидки', __METHOD__);

        $request = Yii::$app->request;

        $role = $request->getBodyParam('id');

        $resultChange = UserRolesClass::DeleteRole($role);

        if (!is_array($resultChange) || !isset($resultChange['status']) || $resultChange['status'] != 'SUCCESS') {
            Yii::error('Ошибка при удалении роли', __METHOD__);

            if (is_array($resultChange) && isset($resultChange['status']) && $resultChange['status'] === 'ERROR') {
                return $resultChange;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при удалении роли',
            ];
        }

        Yii::info('Роль успешно удалена', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Роль успешно удалена',
        ];
    }
}