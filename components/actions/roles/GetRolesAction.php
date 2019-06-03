<?php
/**
 * Получение ролей
 */

namespace app\components\actions\roles;

use app\models\UsersRole;
use Yii;

class GetRolesAction
{
    /**
     * Получение ролей
     * @return bool|array
     */
    public static function GetRoles()
    {
        Yii::info('Запуск функции GetRoles', __METHOD__);
        $result = [];

        $branchList = UsersRole::find()->all();

        if (!is_array($branchList)) {
            Yii::error('Список ролей пуст', __METHOD__);

            return [
                'status' => 'SUCCESS',
                'msg' => 'Список ролей пуст',
                'data' => $result
            ];
        }

        /**
         * @var UsersRole $value
         */
        foreach ($branchList as $value) {
            $result[] = [
                'val' => $value->id,
                'name' => $value->name,
            ];
        }

        Yii::info('Роли успешно получены', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Роли успешно получены',
            'data' => $result
        ];
    }
}