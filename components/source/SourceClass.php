<?php
/**
 * Управление источниками
 */

namespace app\components\source;

use app\models\ClientSource;
use Yii;

class SourceClass
{
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