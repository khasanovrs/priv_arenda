<?php
/**
 * Управление статусами
 */

namespace app\components\Status;

use app\models\ClientSource;
use app\models\ClientStatus;
use app\models\ClientUr;
use Yii;

class StatusClass
{
    /**
     * Добавление нового статуса для юр. лиц
     * @param $name ,
     * @return bool|array
     */
    public static function AddUrStatus($name)
    {
        Yii::info('Запуск функции добавления нового статуса для юр. лиц', __METHOD__);

        if ($name === '') {
            Yii::error('Ни передано наименование статуса, name:' . serialize($name), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ни передано наименование статуса',
            ];
        }

        $new_status = new ClientStatus();
        $new_status->name = $name;

        try {
            if (!$new_status->save(false)) {
                Yii::error('Ошибка при добавлении нового статуса для юр. лиц: ' . serialize($new_status->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при добавлении нового статуса для юр. лиц: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        Yii::info('Статус для юр. лиц успешно добавлен', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Статус для юр. лиц успешно добавлен'
        ];
    }

    /**
     * Удаление статуса юр. лиц
     * @param $id ,
     * @return bool|array
     */
    public static function DeleteUrStatus($id)
    {
        Yii::info('Запуск функции удаления статуса для юр. лиц', __METHOD__);

        if ($id === '') {
            Yii::error('Ни передано идентификатор статуса, id:' . serialize($id), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ни передан идентификатор статуса',
            ];
        }

        $check_status = ClientUr::find()->where('status=:id', [':id' => $id])->one();

        if (is_object($check_status)) {
            Yii::error('Ни передан идентификатор статуса, id:' . serialize($id), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Данный статус нельзя удалить. Статус используется',
            ];
        }

        try {
            ClientStatus::deleteAll('id=:id', array(':id' => $id));
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при удалении статуса: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        Yii::info('Статус успешно удален', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Статус успешно удален'
        ];
    }

    /**
     * Добавление нового источника
     * @param $name ,
     * @return bool|array
     */
    public static function AddUrSource($name)
    {
        Yii::info('Запуск функции добавления нового источника', __METHOD__);

        if ($name === '') {
            Yii::error('Ни передано наименование источника, name:' . serialize($name), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ни передано наименование источника',
            ];
        }

        $new_source = new ClientSource();
        $new_source->name = $name;

        try {
            if (!$new_source->save(false)) {
                Yii::error('Ошибка при добавлении нового источника для юр. лиц: ' . serialize($new_source->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при добавлении нового источника для юр. лиц: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        Yii::info('Источник успешно добавлен', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Источник успешно добавлен'
        ];
    }

    /**
     * Удаление источника
     * @param $id ,
     * @return bool|array
     */
    public static function DeleteUrSource($id)
    {
        Yii::info('Запуск функции удаления источника для юр. лиц', __METHOD__);

        if ($id === '') {
            Yii::error('Ни передан идентификатор источника, id:' . serialize($id), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ни передан идентификатор источника',
            ];
        }

        try {
            ClientSource::deleteAll('id=:id', array(':id' => $id));
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при удалении источника: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        Yii::info('Источник успешно удален', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Источник успешно удален'
        ];
    }
}