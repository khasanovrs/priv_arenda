<?php
/**
 * Управление финансами
 */

namespace app\components\finance;

use app\components\Session\Sessions;
use app\models\FinanceCategory;
use app\models\FinanceField;
use app\models\FinanceShowField;
use app\models\FinanceType;
use Yii;

class FinanceClass
{
    /**
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public static function GetFinanceFields()
    {
        Yii::info('Запуск функции GetFinanceFields', __METHOD__);
        $result = [];

        $applicationsFieldList = FinanceField::find()->orderBy('id')->all();

        if (!is_array($applicationsFieldList)) {
            Yii::error('Список полей пуст', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Список полей оборудования пуст'
            ];
        }

        /**
         * @var Sessions $Sessions
         */
        $Sessions = Yii::$app->get('Sessions');
        $session = $Sessions->getSession();

        if (!is_object($session)) {
            Yii::error('Ошибка при опредении пользователя', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при опредении пользователя'
            ];
        }

        /**
         * @var FinanceField $value
         */
        foreach ($applicationsFieldList as $value) {
            $check_flag = FinanceShowField::find()->where('applications_field_id=:applications_field_id and user_id=:user_id', [':applications_field_id' => $value->id, ':user_id' => $session->user_id])->orderBy('id')->one();

            $flag = is_object($check_flag) ? 0 : 1;

            $result[] = [
                'id' => $value->id,
                'code' => $value->code,
                'name' => $value->name,
                'flag' => $flag
            ];
        }

        Yii::info('Список полей получен', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Список полей получен',
            'data' => $result
        ];
    }

    /**
     * Изменение полей
     * @param $params
     * @return array|bool
     * @throws \yii\base\InvalidConfigException
     */
    public static function ChangeFinanceFields($params)
    {
        Yii::info('Запуск функции ChangeFinanceFields', __METHOD__);

        if (!is_array($params) || empty($params)) {
            Yii::error('Не пришли параметры для изменения', __METHOD__);
        }

        /**
         * @var Sessions $Sessions
         */
        $Sessions = Yii::$app->get('Sessions');
        $session = $Sessions->getSession();

        if (!is_object($session)) {
            Yii::error('Ошибка при опредении пользователя', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при опредении пользователя'
            ];
        }

        try {
            FinanceShowField::deleteAll('user_id=:user_id', [':user_id' => $session->user_id]);
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при очистке списка скрытых полей : ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        foreach ($params as $value) {
            if ($value->flag === 0) {

                $newVal = new FinanceShowField();
                $newVal->user_id = $session->user_id;
                $newVal->applications_field_id = $value->id;

                try {
                    if (!$newVal->save(false)) {
                        Yii::error('Ошибка при изменене отображения поля: ' . serialize($newVal->getErrors()), __METHOD__);
                        return false;
                    }
                } catch (\Exception $e) {
                    Yii::error('Поймали Exception при изменене отображения поля: ' . serialize($e->getMessage()), __METHOD__);
                    return false;
                }
            }
        }


        Yii::info('Поля успешно изменены', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Поля успешно изменены'
        ];
    }


    /**
     * Получение категорий финансов
     * @return bool|array
     */
    public static function GetFinanceCategory()
    {
        Yii::info('Запуск функции GetFinanceCategory', __METHOD__);
        $result = [];

        $equipmentsTypeList = FinanceCategory::find()->orderBy('id')->all();

        if (!is_array($equipmentsTypeList)) {
            Yii::error('Список категорий финансов пуст', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Список категорий финансов пуст'
            ];
        }

        /**
         * @var FinanceCategory $value
         */
        foreach ($equipmentsTypeList as $value) {
            $result[] = [
                'val' => $value->id,
                'name' => $value->name
            ];
        }

        Yii::info('Список категорий финансов получен', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Список категорий финансов получен',
            'data' => $result
        ];
    }


    /**
     * Получение типов финансов
     * @return bool|array
     */
    public static function GetFinanceType()
    {
        Yii::info('Запуск функции GetFinanceType', __METHOD__);
        $result = [];

        $equipmentsTypeList = FinanceType::find()->orderBy('id')->all();

        if (!is_array($equipmentsTypeList)) {
            Yii::error('Список типов финансов пуст', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Список типов финансов пуст'
            ];
        }

        /**
         * @var FinanceType $value
         */
        foreach ($equipmentsTypeList as $value) {
            $result[] = [
                'val' => $value->id,
                'name' => $value->name
            ];
        }

        Yii::info('Список типов финансов получен', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Список типов финансов получен',
            'data' => $result
        ];
    }
}