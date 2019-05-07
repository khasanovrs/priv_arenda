<?php
/**
 * Удаление статуса для юр.лица
 */

namespace app\components\actions\statusUr;

use app\components\Status\StatusClass;
use Yii;
use yii\base\Action;

class DeleteUrStatusAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции удаления статуса для юр.лица', __METHOD__);

        $request = Yii::$app->request;

        $id = $request->getBodyParam('id');

        $resultChange = StatusClass::DeleteUrStatus($id);

        if (!is_array($resultChange) || !isset($resultChange['status']) || $resultChange['status'] != 'SUCCESS') {
            Yii::error('Ошибка при удалении статуса для юр.лица', __METHOD__);

            if (is_array($resultChange) && isset($resultChange['status']) && $resultChange['status'] === 'ERROR') {
                return $resultChange;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при удалении статуса для юр.лица',
            ];
        }

        Yii::info('Статус успешно удален', __METHOD__);

        return [
            'status' => 'ОК',
            'msg' => 'Статус успешно удален',
        ];
    }
}