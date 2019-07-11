<?php
/**
 * Управление ролями
 */

namespace app\components\userRoles;

use app\models\Users;
use app\models\UsersRole;
use Yii;

class UserRolesClass
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

    /**
     * Функция добавления роли
     * @param $role
     * @return array|bool
     */
    public static function AddRole($role)
    {
        Yii::info('Запуск функции AddRole', __METHOD__);

        $newRole = new UsersRole();

        $newRole->name = $role;

        try {
            if (!$newRole->save(false)) {
                Yii::error('Ошибка при добавлении новой роли: ' . serialize($newRole->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при добавлении новой роли: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        return [
            'status' => 'SUCCESS',
            'msg' => 'Роль успешно добавлена'
        ];
    }

    /**
     * Функция удаления филиала
     * @param $role
     * @return array|bool
     */
    public static function DeleteRole($id) {
        Yii::info('Запуск функции DeleteRole', __METHOD__);

        $check_status = Users::find()->where('user_type=:status', [':status' => $id])->one();
        if (is_object($check_status)) {
            Yii::error('Данный статус нельзя удалить. Статус используется, id:' . serialize($id), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Данный статус нельзя удалить. Статус используется',
            ];
        }

        try {
            UsersRole::deleteAll('id=:id', [':id' => $id]);
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при удалении роли: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        return [
            'status' => 'SUCCESS',
            'msg' => 'Роль успешно удалена'
        ];
    }
}