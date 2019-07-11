<?php
/**
 * Управление источниками
 */

namespace app\components\source;

use app\models\Applications;
use app\models\ClientsInfo;
use app\models\Source;
use Yii;

class SourceClass
{
    /**
     * Получение исчтоников
     * @return bool|array
     */
    public static function GetSource()
    {
        Yii::info('Запуск функции GetSource', __METHOD__);
        $result = [];

        $sourceList = Source::find()->all();

        if (!is_array($sourceList)) {
            Yii::error('Список источников пуст', __METHOD__);

            return [
                'status' => 'SUCCESS',
                'msg' => 'Список источников пуст',
                'data' => $result
            ];
        }

        /**
         * @var Source $value
         */
        foreach ($sourceList as $value) {
            $result[] = [
                'val' => $value->id,
                'name' => $value->name,
            ];
        }

        Yii::info('Источники успешно получены', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Источники успешно получены',
            'data' => $result
        ];
    }

    /**
     * Добавление нового источника
     * @param $name ,
     * @return bool|array
     */
    public static function AddSource($name)
    {
        Yii::info('Запуск функции добавления нового источника', __METHOD__);

        if ($name === '') {
            Yii::error('Ни передано наименование источника, name:' . serialize($name), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ни передано наименование источника',
            ];
        }

        $new_source = new Source();
        $new_source->name = $name;

        try {
            if (!$new_source->save(false)) {
                Yii::error('Ошибка при добавлении нового источника для клиента: ' . serialize($new_source->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при добавлении нового источника для клиента: ' . serialize($e->getMessage()), __METHOD__);
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
    public static function DeleteSource($id)
    {
        Yii::info('Запуск функции удаления источника для юр. лиц', __METHOD__);

        if ($id === '') {
            Yii::error('Ни передан идентификатор источника, id:' . serialize($id), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ни передан идентификатор источника',
            ];
        }

        $check_status = ClientsInfo::find()->where('source=:source', [':source' => $id])->one();
        if (is_object($check_status)) {
            Yii::error('Данный статус нельзя удалить. Статус используется, id:' . serialize($id), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Данный статус нельзя удалить. Статус используется',
            ];
        }

        $check_status = Applications::find()->where('source_id=:source', [':source' => $id])->one();
        if (is_object($check_status)) {
            Yii::error('Данный статус нельзя удалить. Статус используется, id:' . serialize($id), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Данный статус нельзя удалить. Статус используется',
            ];
        }

        try {
            Source::deleteAll('id=:id', array(':id' => $id));
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