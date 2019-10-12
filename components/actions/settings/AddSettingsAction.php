<?php
/**
 * Добавление настроек
 */

namespace app\components\actions\settings;

use app\components\settings\SettingsClass;
use Yii;
use yii\base\Action;

class AddSettingsAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции добавления настроек', __METHOD__);

        $request = Yii::$app->request;

        $id = $request->getBodyParam('id');
        $val = $request->getBodyParam('val');

        $resultChange = SettingsClass::AddSettings($id, $val);

        if (!is_array($resultChange) || !isset($resultChange['status']) || $resultChange['status'] != 'SUCCESS') {
            Yii::error('Ошибка при добавлении настройки', __METHOD__);

            if (is_array($resultChange) && isset($resultChange['status']) && $resultChange['status'] === 'SUCCESS') {
                return $resultChange;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при добавлении настройки',
            ];
        }

        Yii::info('Настройки успешно изменены', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Настройки успешно изменены',
        ];
    }
}