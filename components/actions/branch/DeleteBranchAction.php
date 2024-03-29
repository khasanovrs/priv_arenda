<?php
/**
 * Удаление филиала
 */

namespace app\components\actions\branch;

use app\components\branch\BranchClass;
use Yii;
use yii\base\Action;

class DeleteBranchAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции удаления филиала', __METHOD__);

        $request = Yii::$app->request;

        $branch = $request->getBodyParam('id');

        $resultChange = BranchClass::DeleteBranch($branch);

        if (!is_array($resultChange) || !isset($resultChange['status']) || $resultChange['status'] != 'SUCCESS') {
            Yii::error('Ошибка при удалении филиала', __METHOD__);

            if (is_array($resultChange) && isset($resultChange['status']) && $resultChange['status'] === 'ERROR') {
                return $resultChange;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при удалении филиала',
            ];
        }

        Yii::info('Филиал успешно удален', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Филиал успешно удален',
        ];
    }
}