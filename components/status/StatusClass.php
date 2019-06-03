<?php
/**
 * Управление статусами
 */

namespace app\components\Status;

use app\models\ClientStatus;
use Yii;

class StatusClass
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
}