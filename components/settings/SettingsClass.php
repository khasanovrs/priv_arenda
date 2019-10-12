<?php
/**
 * Управление настройками
 */

namespace app\components\settings;

use app\models\Settings;
use Yii;

class SettingsClass
{
    /**
     * Добавление/изменение настроек
     * @param $id
     * @param $val
     * @return array|bool
     */
    public static function AddSettings($id, $val)
    {
        Yii::info('Запуск функции AddSettings', __METHOD__);

        if ($id === '') {
            Yii::info('Не указан идентификатор', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не указан идентификатор'
            ];
        }

        if ($val === '') {
            Yii::info('Не указано значение', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не указано значение'
            ];
        }

        /**
         * @var Settings $setting
         */
        $setting = Settings::find()->where('id=:id', [':id' => $id])->one();

        if (!is_object($setting)) {
            Yii::error('Ошибка при получении настроек', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при получении настроек'
            ];
        }

        $setting->value = $val;

        try {
            if (!$setting->save(false)) {
                Yii::error('Ошибка при изменении значений настроек: ' . serialize($setting->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при изменении значений настроек: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        return [
            'status' => 'SUCCESS',
            'msg' => 'Настройки успешно изменены'
        ];
    }

    /**
     * Получение настроек
     * @return array
     */
    public static function getSettings()
    {
        Yii::info('Запуск функции getSettings', __METHOD__);

        $settings_list_arr = Settings::find()->all();
        $setting_list = [];

        if (empty($settings_list_arr)) {
            Yii::info('Настроек нет', __METHOD__);
        } else {
            /**
             * @var Settings $value
             */
            foreach ($settings_list_arr as $value) {
                $setting_list[] = [
                    'id' => $value->id,
                    'name' => $value->name,
                    'val' => $value->value,
                ];
            }
        }

        Yii::info('Настройки успешно получены', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Настройки успешно получены',
            'data' => $setting_list
        ];
    }
}