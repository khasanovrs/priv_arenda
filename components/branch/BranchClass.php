<?php
/**
 * Управление филиалами
 */

namespace app\components\branch;

use app\models\Applications;
use app\models\Branch;
use app\models\Clients;
use app\models\Stock;
use app\models\Users;
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

    /**
     * Функци добавления филиала
     * @param $branch
     * @param $val
     * @return array|bool
     */
    public static function AddBranch($branch, $val)
    {
        Yii::info('Запуск функции AddBranch', __METHOD__);

        if ($val !== '') {
            $newBranch = Branch::find()->where('id=:id', [':id' => $val])->one();

            if (!is_object($newBranch)) {
                Yii::error('Передан некорректный идентификатор, id:' . serialize($val), __METHOD__);

                return [
                    'status' => 'ERROR',
                    'msg' => 'Передан некорректный идентификатор',
                ];
            }
        } else {
            $newBranch = new Branch();
        }

        $newBranch->name = $branch;

        try {
            if (!$newBranch->save(false)) {
                Yii::error('Ошибка при добавлении нового филиала: ' . serialize($newBranch->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при добавлении нового филиала: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        return [
            'status' => 'SUCCESS',
            'msg' => $val === '' ? 'Филиал успешно добавлен' : 'Филиал успешно обновлен'
        ];
    }

    /**
     * Функция удаления филиала
     * @param $branch
     * @return array|bool
     */
    public static function DeleteBranch($branch)
    {
        Yii::info('Запуск функции DeleteBranch', __METHOD__);

        $check_status = Applications::find()->where('branch_id=:branch_id', [':branch_id' => $branch])->one();
        if (is_object($check_status)) {
            Yii::error('Данный статус нельзя удалить. Статус используется в заявках, id:' . serialize($branch), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Данный статус нельзя удалить. Статус используется в заявках',
            ];
        }

        $check_status = Stock::find()->where('id_branch=:branch_id', [':branch_id' => $branch])->one();
        if (is_object($check_status)) {
            Yii::error('Данный статус нельзя удалить. Статус используется для складов, id:' . serialize($branch), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Данный статус нельзя удалить. Статус используется для складов',
            ];
        }

        $check_status = Users::find()->where('branch_id=:branch_id', [':branch_id' => $branch])->one();
        if (is_object($check_status)) {
            Yii::error('Данный статус нельзя удалить. Статус используется для пользователей, id:' . serialize($branch), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Данный статус нельзя удалить. Статус используется для пользователей',
            ];
        }

        try {
            Branch::deleteAll('id=:id', [':id' => $branch]);
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при удалении филиала: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        return [
            'status' => 'SUCCESS',
            'msg' => 'Филиал успешно удален'
        ];
    }
}