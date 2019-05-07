<?php
/**
 * Редактирование филиала
 */

namespace app\components\actions\branch;

use app\components\Branch\BranchClass;
use Yii;
use yii\base\Action;

class ChangeBranchAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции редактирования филиала', __METHOD__);

        $request = Yii::$app->request;

        $id = $request->getBodyParam('id');
        $branch = $request->getBodyParam('branch');

        $resultChange = BranchClass::ChangeBranch($id, $branch);

        if (!is_array($resultChange) || !isset($resultChange['status']) || $resultChange['status'] != 'SUCCESS') {
            Yii::error('Ошибка при изменении филиала', __METHOD__);

            if (is_array($resultChange) && isset($resultChange['status']) && $resultChange['status'] === 'SUCCESS') {
                return $resultChange;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при изменении филиала',
            ];
        }

        Yii::info('Филиал успешно изменен', __METHOD__);

        return [
            'status' => 'ОК',
            'msg' => 'Филиал успешно изменен',
        ];
    }
}