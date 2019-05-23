<?php
/**
 * Управление парметрами
 */

namespace app\components\params;

use app\models\Branch;
use app\models\ClientSource;
use app\models\ClientStatus;
use app\models\UsersRights;
use app\models\UsersRole;
use Yii;

class ParamsClass
{
    /**
     * Получение статусов
     * @return bool|array
     */
    public static function GetStatus()
    {
        Yii::info('Запуск функции GetStatus', __METHOD__);
        $result = [];

        $statusList = ClientStatus::find()->all();

        if (!is_array($statusList)) {
            Yii::error('Список статусов пуст', __METHOD__);

            return [
                'status' => 'SUCCESS',
                'msg' => 'Список статусов пуст',
                'data' => $result
            ];
        }

        /**
         * @var ClientStatus $value
         */
        foreach ($statusList as $value) {
            $result[] = [
                'val' => $value->id,
                'name' => $value->name,
            ];
        }

        Yii::info('Статусы успешно получены', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Статусы успешно получены',
            'data' => $result
        ];
    }

    /**
     * Получение исчтоников
     * @return bool|array
     */
    public static function GetSource()
    {
        Yii::info('Запуск функции GetSource', __METHOD__);
        $result = [];

        $sourceList = ClientSource::find()->all();

        if (!is_array($sourceList)) {
            Yii::error('Список источников пуст', __METHOD__);

            return [
                'status' => 'SUCCESS',
                'msg' => 'Список источников пуст',
                'data' => $result
            ];
        }

        /**
         * @var ClientSource $value
         */
        foreach ($sourceList as $value) {
            $result[] = [
                'val' => $value->id,
                'name' => $value->name,
            ];
        }

        Yii::info('Источники успешно получены', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Источники успешно получены',
            'data' => $result
        ];
    }

    /**
     * Получение филиалов
     * @return bool|array
     */
    public static function GetBranch()
    {
        Yii::info('Запуск функции GetBranch', __METHOD__);
        $result = [];

        $branchList = Branch::find()->all();

        if (!is_array($branchList)) {
            Yii::error('Список филиалов пуст', __METHOD__);

            return [
                'status' => 'SUCCESS',
                'msg' => 'Список филиалов пуст',
                'data' => $result
            ];
        }

        /**
         * @var Branch $value
         */
        foreach ($branchList as $value) {
            $result[] = [
                'val' => $value->id,
                'name' => $value->name,
            ];
        }

        Yii::info('Филиалы успешно получены', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Филиалы успешно получены',
            'data' => $result
        ];
    }

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