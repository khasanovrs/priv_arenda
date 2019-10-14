<?php
/**
 * Удаление проката
 */

namespace app\components\actions\hire;

use app\components\hire\HireClass;
use Yii;
use yii\base\Action;

class DeleteHireAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции удаления проката', __METHOD__);

        $request = Yii::$app->request;

        $id = $request->getBodyParam('id');

        $result = HireClass::deleteHire($id);

        if (!is_array($result) || !isset($result['status']) || $result['status'] != 'SUCCESS') {
            Yii::error('Ошибка при удалении проката', __METHOD__);

            if (is_array($result) && isset($result['status']) && $result['status'] === 'ERROR') {
                return $result;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при удалении проката',
            ];
        }

        Yii::info('Прокат успешно удален', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Прокат успешно удален'
        ];
    }
}