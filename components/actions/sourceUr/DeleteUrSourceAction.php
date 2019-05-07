<?php
/**
 * Удаление источника
 */

namespace app\components\actions\sourceUr;

use app\components\Status\StatusClass;
use Yii;
use yii\base\Action;

class DeleteUrSourceAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции удаления источника для юр.лица', __METHOD__);

        $request = Yii::$app->request;

        $id = $request->getBodyParam('id');

        $resultChange = StatusClass::DeleteUrSource($id);

        if (!is_array($resultChange) || !isset($resultChange['status']) || $resultChange['status'] != 'SUCCESS') {
            Yii::error('Ошибка при удалении источника', __METHOD__);

            if (is_array($resultChange) && isset($resultChange['status']) && $resultChange['status'] === 'ERROR') {
                return $resultChange;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при удалении источника',
            ];
        }

        Yii::info('Источник успешно удален', __METHOD__);

        return [
            'status' => 'ОК',
            'msg' => 'Источник успешно удален',
        ];
    }
}