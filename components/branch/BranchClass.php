<?php
/**
 * Управление филиалами
 */

namespace app\components\Branch;

use app\models\Branch;
use Yii;

class BranchClass
{
    /**
     * Получение филиалов
     * @return bool|array
     */
    public static function GetBranch()
    {
        Yii::info('Запуск функции GetBranch', __METHOD__);
        $result = [];

        $branchList = Branch::find()->all();

        if (!is_array($branchList)) {
            Yii::error('Список филиалов пуст', __METHOD__);

            return [
                'status' => 'SUCCESS',
                'msg' => 'Список филиалов пуст',
                'data' => $result
            ];
        }

        /**
         * @var Branch $value
         */
        foreach ($branchList as $value) {
            $result[] = [
                'val' => $value->id,
                'name' => $value->name,
            ];
        }

        Yii::info('Филиалы успешно получены', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Филиалы успешно получены',
            'data' => $result
        ];
    }
}