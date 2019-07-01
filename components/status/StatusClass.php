<?php
/**
 * Управление статусами
 */

namespace app\components\Status;

use app\models\ClientStatus;
use Yii;

class StatusClass
{
    /**
     * Получение статусов
     * @return bool|array
     */
    public static function GetStatus()
    {
        Yii::info('Запуск функции GetStatus', __METHOD__);
        $result = [];

        $statusList = ClientStatus::find()->all();

        if (!is_array($statusList)) {
            Yii::error('Список статусов пуст', __METHOD__);

            return [
                'status' => 'SUCCESS',
                'msg' => 'Список статусов пуст',
                'data' => $result
            ];
        }

        /**
         * @var ClientStatus $value
         */
        foreach ($statusList as $value) {
            $result[] = [
                'val' => $value->id,
                'name' => $value->name,
            ];
        }

        Yii::info('Статусы успешно получены', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Статусы успешно получены',
            'data' => $result
        ];
    }

    /**
     * Добавление нового статуса для клиента
     * @param $name ,
     * @return bool|array
     */
    public static function AddStatus($name)
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
                Yii::error('Ошибка при добавлении нового статуса для клиента: ' . serialize($new_status->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при добавлении нового статуса для клиента: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        Yii::info('Статус для клиента успешно добавлен', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Статус для клиента успешно добавлен'
        ];
    }

    /**
     * Удаление статуса юр. лиц
     * @param $id ,
     * @return bool|array
     */
    public static function DeleteStatus($id)
    {
        Yii::info('Запуск функции удаления статуса для клиента', __METHOD__);

        if ($id === '') {
            Yii::error('Ни передано идентификатор статуса, id:' . serialize($id), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ни передан идентификатор статуса',
            ];
        }

        $check_status = ClientStatus::find()->where('id=:id', [':id' => $id])->one();

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
}