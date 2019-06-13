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
}