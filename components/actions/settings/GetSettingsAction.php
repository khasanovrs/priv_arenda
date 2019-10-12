<?php
/**
 * Получение настроек
 */

namespace app\components\actions\settings;

use app\components\settings\SettingsClass;
use Yii;
use yii\base\Action;

class GetSettingsAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции получения настроек', __METHOD__);

        $result = SettingsClass::getSettings();

        if (!is_array($result) || !isset($result['status']) || $result['status'] != 'SUCCESS') {
            Yii::error('Ошибка при получении настроек', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при получении настроек',
            ];
        }

        Yii::info('Настройки успешно получены', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Настройки успешно получены',
            'data' => $result['data']
        ];
    }
}