<?php
/**
 * Управление парметрами
 */

namespace app\components\params;

use app\models\ClientSource;
use app\models\ClientStatus;
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
}