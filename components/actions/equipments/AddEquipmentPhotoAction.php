<?php
/**
 * добавление фотографии оборудования
 */

namespace app\components\actions\equipments;

use app\components\equipments\EquipmentsClass;
use Yii;
use yii\base\Action;

class AddEquipmentPhotoAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции добавления фотографии оборудования', __METHOD__);

        $request = Yii::$app->request;

        $files = $request->getBodyParam('files');
        $file_name = $request->getBodyParam('file_name');

        $result = EquipmentsClass::AddEquipmentPhoto($file_name, $files);

        if (!is_array($result) || !isset($result['status']) || $result['status'] != 'SUCCESS') {
            Yii::error('Ошибка при добавлении фотографии оборудования', __METHOD__);

            if (is_array($result) && isset($result['status']) && $result['status'] === 'ERROR') {
                return $result;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при добавлении фотографии оборудования',
            ];
        }

        Yii::info('Фотография оборудования успешно добавлено', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Фотография оборудования успешно добавлено'
        ];
    }
}