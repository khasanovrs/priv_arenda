<?php
/**
 * Управление правами
 */

namespace app\components\userRights;

use app\models\BunchUserRight;
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
     * @param $val
     * @return array|bool
     */
    public static function AddRight($right, $val)
    {
        Yii::info('Запуск функции AddRight', __METHOD__);

        if ($val !== '') {
            $newRight = UsersRights::find()->where('id=:id', [':id' => $val])->one();

            if (!is_object($newRight)) {
                Yii::error('Передан некорректный идентификатор, id:' . serialize($val), __METHOD__);

                return [
                    'status' => 'ERROR',
                    'msg' => 'Передан некорректный идентификатор',
                ];
            }
        } else {
            $newRight = new UsersRights();
        }

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
            'msg' => $val === '' ? 'Права успешно добавлены' : 'Права успешно обновлены'
        ];
    }

    /**
     * Функция удаления филиала
     * @param $id
     * @return array|bool
     */
    public static function DeleteRight($id)
    {
        Yii::info('Запуск функции DeleteRight', __METHOD__);

        $check_status = BunchUserRight::find()->where('right_id=:status', [':status' => $id])->one();
        if (is_object($check_status)) {
            Yii::error('Данный статус нельзя удалить. Статус используется, id:' . serialize($id), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Данный статус нельзя удалить. Статус используется',
            ];
        }

        try {
            UsersRights::deleteAll('id=:id', [':id' => $id]);
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