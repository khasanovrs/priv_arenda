<?php
/**
 * Добавление нового статуса заявки
 */

namespace app\components\actions\applications;

use app\components\applications\ApplicationsClass;
use Yii;
use yii\base\Action;

class AddApplicationsStatusAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции добавления новой заявки', __METHOD__);

        $request = Yii::$app->request;

        $name = $request->getBodyParam('name');

        $resultChange = ApplicationsClass::AddStatus($name);

        if (!is_array($resultChange) || !isset($resultChange['status']) || $resultChange['status'] != 'SUCCESS') {
            Yii::error('Ошибка при добавлении нового статуса для заявки', __METHOD__);

            if (is_array($resultChange) && isset($resultChange['status']) && $resultChange['status'] === 'ERROR') {
                return $resultChange;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при добавлении нового статуса для заявки',
            ];
        }

        Yii::info('Статус для заявки успешно добавлен', __METHOD__);

        return [
            'status' => 'ОК',
            'msg' => 'Статус успешно добавлен',
        ];
    }
}