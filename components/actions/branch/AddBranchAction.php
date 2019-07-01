<?php
/**
 * Добавление филиала
 */

namespace app\components\actions\branch;

use app\components\Branch\BranchClass;
use Yii;
use yii\base\Action;

class AddBranchAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции добавления филиала', __METHOD__);

        $request = Yii::$app->request;

        $branch = $request->getBodyParam('branch');

        $resultChange = BranchClass::AddBranch($branch);

        if (!is_array($resultChange) || !isset($resultChange['status']) || $resultChange['status'] != 'SUCCESS') {
            Yii::error('Ошибка при добавлении нового филиала', __METHOD__);

            if (is_array($resultChange) && isset($resultChange['status']) && $resultChange['status'] === 'SUCCESS') {
                return $resultChange;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при добавлении нового филиала',
            ];
        }

        Yii::info('Филиал успешно добавлен', __METHOD__);

        return [
            'status' => 'ОК',
            'msg' => 'Филиал успешно добавлен',
        ];
    }
}