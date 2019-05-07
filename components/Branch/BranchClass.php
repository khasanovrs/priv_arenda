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
     * Добавление нового филиала
     * @param $name ,
     * @return bool|array
     */
    public static function AddBranch($name)
    {
        Yii::info('Запуск функции добавления нового филиала', __METHOD__);

        if ($name === '') {
            Yii::error('Ни передано наименование филиала, name:' . serialize($name), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ни передано наименование филиала',
            ];
        }

        $new_branch = new Branch();
        $new_branch->name = $name;

        try {
            if (!$new_branch->save(false)) {
                Yii::error('Ошибка при добавлении нового филиала: ' . serialize($new_branch->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при добавлении нового филиала: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        Yii::info('Филиал успешно добавлен', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Филиал успешно добавлен'
        ];
    }

    /**
     * Редактирование филиала
     * @param $name ,
     * @return bool|array
     */
    public static function ChangeBranch($id, $name)
    {
        Yii::info('Запуск функции редактирования филиала', __METHOD__);

        if ($id === '') {
            Yii::error('Ни передан идентификатор филиала, id:' . serialize($id), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ни передан идентификатор филиала',
            ];
        }

        if ($name === '') {
            Yii::error('Ни передано наименование филиала, name:' . serialize($name), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ни передано наименование филиала',
            ];
        }

        /**
         * @var Branch $branch
         */
        $branch = Branch::find()->where('id=:id', [':id' => $id])->one();

        if (!is_object($branch)) {
            Yii::error('Филиал ни найден, id:' . serialize($id), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Филиал ни найден',
            ];
        }

        $branch->name = $name;

        try {
            if (!$branch->save(false)) {
                Yii::error('Ошибка при изменении филиала: ' . serialize($branch->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при изменении филиала: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        Yii::info('Филиал успешно изменен', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Филиал успешно изменен'
        ];
    }
}