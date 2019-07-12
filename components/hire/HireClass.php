<?php
/**
 * Управление прокатом
 */

namespace app\components\hire;

use app\components\Session\Sessions;
use app\models\ApplicationEquipment;
use app\models\Applications;
use app\models\HireField;
use app\models\HireShowField;
use app\models\HireStatus;
use Yii;

class HireClass
{
    /**
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public static function GetHireFields()
    {
        Yii::info('Запуск функции GetHireFields', __METHOD__);
        $result = [];

        $applicationsFieldList = HireField::find()->orderBy('id')->all();

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
         * @var HireField $value
         */
        foreach ($applicationsFieldList as $value) {
            $check_flag = HireShowField::find()->where('hire_field_id=:hire_field_id and user_id=:user_id', [':hire_field_id' => $value->id, ':user_id' => $session->user_id])->orderBy('id')->one();

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
    public static function ChangeHireFields($params)
    {
        Yii::info('Запуск функции ChangeHireFields', __METHOD__);

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
            HireShowField::deleteAll('user_id=:user_id', [':user_id' => $session->user_id]);
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при очистке списка скрытых полей : ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        foreach ($params as $value) {
            if ($value->flag === 0) {

                $newVal = new HireShowField();
                $newVal->user_id = $session->user_id;
                $newVal->hire_field_id = $value->id;

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
     * Получение статусов проката
     * @return bool|array
     */
    public static function GetHireStatus()
    {
        Yii::info('Запуск функции GetHireStatus', __METHOD__);
        $result = [];

        $list = HireStatus::find()->orderBy('id')->all();

        if (!is_array($list)) {
            Yii::error('Список статусов проката пуст', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Список статусов проката пуст'
            ];
        }

        /**
         * @var HireStatus $value
         */
        foreach ($list as $value) {
            $result[] = [
                'val' => $value->id,
                'name' => $value->name,
                'color' => $value->color
            ];
        }

        Yii::info('Список статусов проката получен', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Список статусов проката получен',
            'data' => $result
        ];
    }

    /**
     * Обновлене статуса у проката
     * @param $id
     * @param $status
     * @return array|bool
     */
    public static function UpdateHireStatus($id, $status)
    {
        Yii::info('Запуск функции UpdateHireStatus', __METHOD__);

        if ($id === '' || !is_int($status)) {
            Yii::error('Не передан идентификтор заявки, id: ' . serialize($id), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не передан идентификтор заявки',
            ];
        }

        if ($status === '' || !is_int($status)) {
            Yii::error('Передан некорректный статус, status: ' . serialize($status), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Передан некорректный статус',
            ];
        }

        $check_status = HireStatus::find()->where('id=:id', [':id' => $status])->one();

        if (!is_object($check_status)) {
            Yii::error('Передан некорректный статус, status:' . serialize($status), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Передан некорректный статус',
            ];
        }

        /**
         * @var ApplicationEquipment $applications
         */
        $applications = ApplicationEquipment::find()->where('id=:id', [':id' => $id])->one();

        if (!is_object($applications)) {
            Yii::error('По данному идентификатору заявка не найдена, id' . serialize($id), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Заявка не найдена',
            ];
        }

        $applications->hire_status_id = $status;

        try {
            if (!$applications->save(false)) {
                Yii::error('Ошибка при обновлении статуса проката: ' . serialize($applications->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при обновлении статуса проката: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        Yii::info('Статус проката успешно изменен', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Статус проката успешно изменен'
        ];
    }

    /**
     * Получение списка прокатов
     * @param $status
     * @param $branch
     * @param $date_start
     * @param $date_end
     * @param $sum_start
     * @param $sum_end
     * @return array
     */
    public static function GetHire($status, $branch, $date_start, $date_end, $sum_start, $sum_end)
    {
        Yii::info('Запуск функции GetHire', __METHOD__);
        $result = [];

        $list = ApplicationEquipment::find()->where('status_id in (2,3)')->all();

        if (empty($list)) {
            Yii::info('Список прокатов пуст', __METHOD__);

            return [
                'status' => 'SUCCESS',
                'msg' => 'Список прокатов пуст',
                'data' => $result
            ];
        }

        /**
         * @var ApplicationEquipment $value
         */
        foreach ($list as $value) {
            /**
             * @var Applications $application
             */
            $application = Applications::find()->where('id=:id', [':id' => $value->application_id])->one();

            if (!is_object($application)) {
                Yii::info('Ошибка при поиске заявления', __METHOD__);

                return [
                    'status' => 'ERROR',
                    'msg' => 'Ошибка при поиске заявления'
                ];
            }

            $mark = $value->equipments->mark0->name;
            $model = $value->equipments->model;
            $category = $value->equipments->category->name;

            $result[] = [
                'client' => $client = $application->client->name,
                'equipments' => $category . ' ' . $mark . ' ' . $model,
                'start_hire' => '',
                'end_hire' => '',
                'status' => $value->hire_status_id,
                'sum' => $application->total_sum,
                'sale_sum' => $application->sum,
                'total_paid' => $value->equipments->total_paid,
                'remainder' => '',
                'date_create' => $application->date_create,
                'comment' => $application->comment,
                'date_end' => '',
                'branch' => $application->branch->name,
                'current_pay' => ''
            ];
        }

        Yii::info('Список прокатов получен', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Список прокатов получен',
            'data' => $result
        ];
    }
}