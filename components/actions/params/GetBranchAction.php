<?php
/**
 * Получение филиалов
 */

namespace app\components\actions\params;


use app\components\params\ParamsClass;
use Yii;
use yii\base\Action;

class GetBranchAction extends Action
{
    public function run()
    {
        Yii::info('Запуск функции получения филиалов', __METHOD__);

        $resultChange = ParamsClass::GetBranch();

        if (!is_array($resultChange) || !isset($resultChange['status']) || $resultChange['status'] != 'SUCCESS') {
            Yii::error('Ошибка при получении филиалов', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при получении филиалов',
            ];
        }

        Yii::info('Список филиалов успешно получен', __METHOD__);

        return [
            'status' => 'OK',
            'msg' => 'Список филиалов успешно получен',
            'data' => $resultChange['data']
        ];
    }
}