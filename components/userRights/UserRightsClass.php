<?php
/**
 * Управление правами
 */

namespace app\components\userRights;

use app\models\UsersRights;
use Yii;

class UserRightsClass
{
    /**
     * Получение прав
     * @return bool|array
     */
    public static function GetRights()
    {
        Yii::info('Запуск функции GetRights', __METHOD__);
        $result = [];

        $branchList = UsersRights::find()->all();

        if (!is_array($branchList)) {
            Yii::error('Список ролей пуст', __METHOD__);

            return [
                'status' => 'SUCCESS',
                'msg' => 'Список ролей пуст',
                'data' => $result
            ];
        }

        /**
         * @var UsersRights $value
         */
        foreach ($branchList as $value) {
            $result[] = [
                'val' => $value->id,
                'name' => $value->name,
                'checked' => false
            ];
        }

        Yii::info('Права успешно получены', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Права успешно получены',
            'data' => $result
        ];
    }


    /**
     * Функция добавления роли
     * @param $right
     * @return array|bool
     */
    public static function AddRight($right)
    {
        Yii::info('Запуск функции AddRight', __METHOD__);

        $newRight = new UsersRights();

        $newRight->name = $right;

        try {
            if (!$newRight->save(false)) {
                Yii::error('Ошибка при добавлении нового права: ' . serialize($newRight->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при добавлении нового права: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        return [
            'status' => 'SUCCESS',
            'msg' => 'Права успешно добавлены'
        ];
    }

    /**
     * Функция удаления филиала
     * @param $right
     * @return array|bool
     */
    public static function DeleteRight($right) {
        Yii::info('Запуск функции DeleteRight', __METHOD__);

        try {
            UsersRights::deleteAll('id=:id', [':id' => $right]);
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при удалении права: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        return [
            'status' => 'SUCCESS',
            'msg' => 'Права успешно удалены'
        ];
    }
}