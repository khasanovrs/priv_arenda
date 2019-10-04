<?php
/**
 * Управление прокатом
 */

namespace app\components\hire;

use app\components\Clients\ClientsClass;
use app\components\pay\PayClass;
use app\components\Session\Sessions;
use app\models\ApplicationEquipment;
use app\models\ApplicationPay;
use app\models\Applications;
use app\models\Equipments;
use app\models\EquipmentsStatus;
use app\models\Extension;
use app\models\HireField;
use app\models\HireShowField;
use app\models\HireState;
use app\models\HireStatus;
use Symfony\Component\Console\Application;
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
     * Получение состояний проката
     * @return bool|array
     */
    public static function GetHireState()
    {
        Yii::info('Запуск функции GetHireState', __METHOD__);
        $result = [];

        $list = HireState::find()->orderBy('id')->all();

        if (!is_array($list)) {
            Yii::error('Список состояний проката пуст', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Список состояний проката пуст'
            ];
        }

        /**
         * @var HireStatus $value
         */
        foreach ($list as $value) {
            $result[] = [
                'val' => $value->id,
                'name' => $value->name,
            ];
        }

        Yii::info('Список состояний проката получен', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Список состояний проката получен',
            'data' => $result
        ];
    }

    /**
     * Добавление нового статуса для проката
     * @param $name
     * @param $color
     * @param $val
     * @return bool|array
     */
    public static function AddStatus($name, $color, $val)
    {
        Yii::info('Запуск функции добавления нового статуса для проката', __METHOD__);

        if ($name === '') {
            Yii::error('Ни передано наименование статуса, name:' . serialize($name), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ни передано наименование статуса',
            ];
        }

        if ($val !== '') {
            $new_status = HireStatus::find()->where('id=:id', [':id' => $val])->one();

            if (!is_object($new_status)) {
                Yii::error('Передан некорректный идентификатор, id:' . serialize($val), __METHOD__);

                return [
                    'status' => 'ERROR',
                    'msg' => 'Передан некорректный идентификатор',
                ];
            }
        } else {
            $new_status = new HireStatus();
        }

        $new_status->name = $name;
        $new_status->color = $color;

        try {
            if (!$new_status->save(false)) {
                Yii::error('Ошибка при добавлении нового статуса для проката: ' . serialize($new_status->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при добавлении нового статуса для проката: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        Yii::info('Статус для проката успешно добавлен', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => $val === '' ? 'Статус для проката успешно добавлен' : 'Статус для проката успешно обновлен'
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
     * @param $like
     * @param $branch
     * @param $date_start
     * @param $date_end
     * @param $sum_start
     * @param $sum_end
     * @return array
     */
    public static function GetHire($status, $like, $branch, $date_start, $date_end, $sum_start, $sum_end)
    {
        Yii::info('Запуск функции GetHire', __METHOD__);
        $result = [];
        $listFilter = [];
        $params = [];

        if ($status !== '' and $status !== null) {
            Yii::info('Параметр status: ' . serialize($status), __METHOD__);
            $listFilter[] = 'hire_status_id=:status';
            $params[':status'] = $status;
        }

        if ($branch !== '' and $branch !== null) {
            Yii::info('Параметр branch: ' . serialize($branch), __METHOD__);
            $listFilter[] = 'applications.branch_id=:branch';
            $params[':branch'] = $branch;
        }

        if ($date_start !== '' and $date_start !== null) {
            Yii::info('Параметр date_start: ' . serialize($date_start), __METHOD__);
            $listFilter[] = 'applications.date_create>:date_start';
            $params[':date_start'] = $date_start;
        }

        if ($date_end !== '' and $date_end !== null) {
            Yii::info('Параметр date_end: ' . serialize($date_end), __METHOD__);
            $listFilter[] = 'applications.date_create<:date_end';
            $params[':date_end'] = $date_end;
        }

        if ($date_end !== '' and $date_end !== null) {
            Yii::info('Параметр date_end: ' . serialize($date_end), __METHOD__);
            $listFilter[] = 'applications.date_create<:date_end';
            $params[':date_end'] = $date_end;
        }

        if ($like !== '' and $like !== null) {
            Yii::info('Параметр like: ' . serialize($like), __METHOD__);
            $like = strtolower($like);
            $like = '%' . $like . '%';
            $listFilter[] = ' lower(clients.name) like :like or lower(equipments.model) like :like or lower(equipments_mark.name) like :like or lower(equipments_type.name) like :like';
            $params[':like'] = $like;
        }

        if (!empty($listFilter)) {
            $list = ApplicationEquipment::find()->joinWith(['application', 'equipments', 'equipments.mark0', 'equipments.type0'])->leftJoin('clients', '`clients`.`id` = `applications`.`client_id`')->where(implode(" and ", $listFilter), $params)->orderBy('id desc')->all();
        } else {
            $list = ApplicationEquipment::find()->orderBy('id desc')->all();
        }


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

            $date_cr = date('Y-m-d');

            /**
             * @var ApplicationPay $checkPay
             */
            $checkPay = ApplicationPay::find()->where('application_equipment_id=:id and date_create like :date', [':id' => $value->id, ':date' => $date_cr . '%'])->one();

            $mark = $value->equipments->mark0->name;
            $model = $value->equipments->model;
            $type = $value->equipments->type0->name;
            $sum = $value->equipments->price_per_day;
            $sale = $application->discount->name;
            $total_paid = (float)$sum - ((float)$sum * (float)$sale / 100);

            $client = ClientsClass::GetClientInfo($application->client_id);

            $result[] = [
                'id' => $value->id,
                'app_id' => $application->id,
                'typeLease_id' => $application->type_lease_id,
                'client' => $client = $client->name,
                'equipments' => $type . ' ' . $mark . ' ' . $model,
                'start_hire' => date('d.m.Y H:i:s', strtotime($application->rent_start)),
                'end_hire' => date('d.m.Y H:i:s', strtotime($application->rent_end)),
                'status' => $value->hire_status_id,
                'state' => $value->hireState->name,
                'color' => $value->hireStatus->color,
                'sum' => $sum,
                'sale_sum' => $total_paid,
                'total_paid' => $value->total_paid,
                'remainder' => $value->sum - $value->total_paid,
                'date_create' => date('d.m.Y H:i:s', strtotime($application->date_create)),
                'comment' => $application->comment,
                'date_end' => $application->date_end,
                'branch' => $application->branch->name,
                'current_pay' => is_object($checkPay) ? $checkPay->sum : '0'
            ];
        }

        Yii::info('Список прокатов получен', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Список прокатов получен',
            'data' => $result
        ];
    }


    /**
     * Получение списка прокатов
     * @param $id
     * @return array
     */
    public static function getHireInfo($id)
    {
        if ($id === '') {
            Yii::error('Не передан идентификатор заявки, applicationId: ' . serialize($id), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не передан идентификатор клиента',
            ];
        }

        /**
         * @var ApplicationEquipment $applicationEq
         */
        $applicationEq = ApplicationEquipment::find()->where('id=:id', [':id' => $id])->one();

        if (!is_object($applicationEq)) {
            Yii::info('Ошибка при получении оборудования у заявки', __METHOD__);

            return [
                'status' => 'SUCCESS',
                'msg' => 'Ошибка при получении заявки'
            ];
        }


        $application = Applications::find()->where('id=:id', [':id' => $applicationEq->application_id])->one();

        if (!is_object($application)) {
            Yii::info('Ошибка при получении заявки', __METHOD__);

            return [
                'status' => 'SUCCESS',
                'msg' => 'Ошибка при получении заявки'
            ];
        }

        /**
         * @var Applications $application
         */

        $sum_sale = (float)$applicationEq->sum - ((float)$applicationEq->sum * (float)$application->discount->name / 100);
        $client = ClientsClass::GetClientInfo($application->client_id);

        $mark = $applicationEq->equipments->mark0->name;
        $model = $applicationEq->equipments->model;
        $category = $applicationEq->equipments->category->name;

        $pay_list = PayClass::getPayList($applicationEq->id);

        if (!is_array($pay_list) || !isset($pay_list['status']) || $pay_list['status'] != 'SUCCESS') {
            Yii::error('Ошибка при получении платежей', __METHOD__);

            if (is_array($pay_list) && isset($result['status']) && $pay_list['status'] === 'ERROR') {
                return $pay_list;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при получении платежей',
            ];
        }

        $extensions_list = PayClass::getExtensions($applicationEq->id);

        if (!is_array($extensions_list) || !isset($extensions_list['status']) || $extensions_list['status'] != 'SUCCESS') {
            Yii::error('Ошибка при получении продлений', __METHOD__);

            if (is_array($extensions_list) && isset($result['status']) && $extensions_list['status'] === 'ERROR') {
                return $extensions_list;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при получении продлений',
            ];
        }

        $result = [
            'id' => $applicationEq->id,
            'branch' => $application->branch->name,
            'app_id' => $application->id,
            'delivery' => $application->delivery_id,
            'typeLease' => $application->typeLease->name,
            'typeLease_id' => $application->type_lease_id,
            'sale' => $application->discount_id,
            'source' => $application->source->name,
            'comment' => $application->comment,
            'rent_start' => $application->rent_start,
            'rent_end' => $application->rent_end,
            'client_fio' => $client->name,
            'client_phone' => $client->phone,
            'delivery_sum' => $applicationEq->delivery_sum,
            'sum' => $applicationEq->sum,
            'sum_sale' => $sum_sale,
            'total_paid' => $applicationEq->total_paid,
            'remainder' => $sum_sale - $applicationEq->total_paid,
            'count' => $applicationEq->equipments_count,
            'equipments' =>
                [
                    'equipments_id' => $applicationEq->equipments_id,
                    'name' => $category . ' ' . $mark . ' ' . $model,
                    'state' => $applicationEq->hireState->name,
                    'photo' => $applicationEq->equipments->photo,
                    'photo_alias' => $applicationEq->equipments->photo_alias
                ],
            'extensions' => $extensions_list['data'],
            'pay_list' => $pay_list['data']
        ];


        Yii::info('Заявка успешно получена', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Заявка успешно получена',
            'data' => $result
        ];
    }

    /**
     * Функция изменения заявки
     * @param $id
     * @param $comment
     * @param $delivery ,
     * @param $sale ,
     * @param $rent_start ,
     * @param $rent_end
     * @return array|bool
     */
    public static function UpdateHire($id, $comment, $delivery, $sale, $rent_start, $rent_end)
    {
        if ($id === '') {
            Yii::error('Не передан идентификатор заявки, applicationId: ' . serialize($id), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не передан идентификатор клиента',
            ];
        }

        /**
         * @var ApplicationEquipment $applicationEq
         */
        $applicationEq = ApplicationEquipment::find()->where('id=:id', [':id' => $id])->one();

        if (!is_object($applicationEq)) {
            Yii::info('Ошибка при получении заявки', __METHOD__);

            return [
                'status' => 'SUCCESS',
                'msg' => 'Ошибка при получении заявки'
            ];
        }

        $applicationEq->application->comment = $comment;

        try {
            if (!$applicationEq->save(false)) {
                Yii::error('Ошибка при изменении заявки: ' . serialize($applicationEq->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при изменении заявки: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        /**
         * @var Applications $app
         */
        $app = Applications::find()->where('id=:id', [':id' => $applicationEq->application_id])->one();

        if (!is_object($app)) {
            Yii::info('Ошибка при получении основной заявки', __METHOD__);

            return [
                'status' => 'SUCCESS',
                'msg' => 'Ошибка при получении заявки'
            ];
        }

        $app->discount_id = $sale;
        $app->delivery_id = $delivery;
        $app->rent_start = date('Y-m-d H:i:s', strtotime($rent_start));
        $app->rent_end = date('Y-m-d H:i:s', strtotime($rent_end));

        try {
            if (!$app->save(false)) {
                Yii::error('Ошибка при изменении основной заявки: ' . serialize($app->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при изменении основной заявки: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        $check = self::checkHire($id);

        if (!is_array($check) || !isset($check['status']) || $check['status'] != 'SUCCESS') {
            Yii::error('Ошибка при продлении контракта', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при изменении состояния',
            ];
        }

        Yii::info('Заявка успешно изменена', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Заявка успешно изменена'
        ];
    }

    /**
     * @param $app_eq_id
     * @param $app_id
     * @param $count
     * @return array|bool
     * @throws \yii\base\InvalidConfigException
     */
    public static function ExtendRental($app_eq_id, $app_id, $count)
    {
        Yii::info('Запуск функции ExtendRental', __METHOD__);

        if ($app_id === '') {
            Yii::error('Не передан идентификатор заявки', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не передан идентификатор заявки',
            ];
        }

        if ($count === '') {
            Yii::error('Не передано поличество', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не передано поличество',
            ];
        }

        Yii::info('Получаем заявку', __METHOD__);

        /**
         * @var Applications $applications
         */
        $applications = Applications::find()->where('id=:id', [':id' => $app_id])->one();

        if (!is_object($applications)) {
            Yii::info('Ошибка при получении заявки', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при получении заявки'
            ];
        }

        if ($applications->type_lease_id === 1) {
            $date = date("Y-m-d H:i:s", strtotime($applications->rent_end . " +" . $count . " days"));
        } else {
            $date = date("Y-m-d H:i:s", strtotime($applications->rent_end . " +" . $count . " month"));
        }

        $applications->rent_end = $date;

        Yii::info('Сохраняем заявку', __METHOD__);

        try {
            if (!$applications->save(false)) {
                Yii::error('Ошибка при изменении даты: ' . serialize($applications->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при изменении даты: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        Yii::info('Получаем информацию заявки с оборудованием', __METHOD__);

        /**
         * @var ApplicationEquipment $app_eq
         */
        $app_eq = ApplicationEquipment::find()->where('id=:id', ['id' => $app_eq_id])->one();

        if (!is_object($app_eq)) {
            Yii::info('Ошибка при получении заявки с оборудованием', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при получении заявки с оборудованием'
            ];
        }

        Yii::info('Получаем оборудование', __METHOD__);

        /**
         * @var Equipments $equipments
         */
        $equipments = Equipments::find()->where('id=:id', [':id' => $app_eq->equipments_id])->one();

        if (!is_object($equipments)) {
            Yii::info('Ошибка при получении оборудования', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при получении оборудования'
            ];
        }

        $datediff = strtotime($applications->rent_end) - strtotime($applications->rent_start);
        $price = ($datediff / (60 * 60 * 24)) * $equipments->price_per_day;

        if ((int)$applications->discount->code !== 0) {
            $price = $price - ($price * $applications->discount->code / 100);
        }

        $app_eq->sum = $price;
        $app_eq->hire_state_id = 7;
        $app_eq->renewals_date = date('Y-m-d H:i:s');

        Yii::info('Сохраняем сумму, сумма: ' . serialize($price), __METHOD__);

        try {
            if (!$app_eq->save(false)) {
                Yii::error('Ошибка при сохранении новой суммы: ' . serialize($app_eq->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при сохранении новой суммы: ' . serialize($e->getMessage()), __METHOD__);
            return false;
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

        $extension = new Extension();
        $extension->count = $count;
        $extension->date_create = date('Y-m-d H:i:s');
        $extension->user_id = $session->user_id;
        $extension->type = $app_eq->application->type_lease_id;
        $extension->application_equipment_id = $app_eq->id;

        try {
            if (!$extension->save(false)) {
                Yii::error('Ошибка при сохранении продления: ' . serialize($extension->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при сохранении продления: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        $check = self::checkHire($app_eq_id);

        if (!is_array($check) || !isset($check['status']) || $check['status'] != 'SUCCESS') {
            Yii::error('Ошибка при продлении контракта', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при изменении состояния',
            ];
        }

        Yii::info('Заявка успешно изменена', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Заявка успешно изменена'
        ];
    }

    /**
     * Функция возврата товара на склад
     * @param $app_id
     * @param $checkPrim
     * @return array|bool
     */
    public static function closeHire($app_id, $checkPrim)
    {
        Yii::info('Запуск функции closeHire', __METHOD__);

        if ($app_id === '') {
            Yii::error('Не передан идентификатор заявки', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не передан идентификатор заявки',
            ];
        }

        $check = self::checkHire($app_id, $checkPrim);

        if (!is_array($check) || !isset($check['status']) || $check['status'] != 'SUCCESS') {
            Yii::error('Ошибка при продлении контракта', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при изменении состояния',
            ];
        }

        Yii::info('Заявка успешно изменена', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Заявка успешно изменена'
        ];
    }

    /**
     * Проверка и изменение состояния у проката
     * @param $ap_eq_id
     * @param $checkPrim
     * @return array|bool
     */
    public static function checkHire($ap_eq_id, $checkPrim = false)
    {
        Yii::info('Проверка и изменение состояния проката', __METHOD__);

        /**
         * @var ApplicationEquipment $app_eq
         */
        $app_eq = ApplicationEquipment::find()->where('id=:id', [':id' => $ap_eq_id])->one();

        if (!is_object($app_eq)) {
            Yii::info('Информация об оборудовании по заявке не найдена', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Заявка не найдена'
            ];
        }

        /**
         * @var Applications $app
         */
        $app = $app_eq->application;

        if (!is_object($app)) {
            Yii::info('Заявка не найдена', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Заявка не найдена'
            ];
        }

        $state = '';

        if (date('Y-m-d H:i:s', strtotime($app->rent_start)) < date('Y-m-d H:i:s') && date('Y-m-d H:i:s', strtotime($app->rent_end)) > date('Y-m-d H:i:s')) {
            Yii::info('Заявка в статусе: прокат', __METHOD__);
            $state = '4';
        }

        if (date('Y-m-d H:i:s', strtotime($app->rent_start)) > date('Y-m-d H:i:s')) {
            Yii::info('Заявка в статусе: бронь', __METHOD__);
            $state = '1';
        }

        if (date('Y-m-d H:i:s', strtotime($app->rent_end)) < date('Y-m-d H:i:s')) {
            if ($app_eq->sum == $app_eq->total_paid) {
                Yii::info('Сумма совпадает', __METHOD__);
                Yii::info('Заявка в статусе: закрыт', __METHOD__);
                $state = 3;
            } else {
                Yii::info('Сумма не совпадает', __METHOD__);
                Yii::info('Заявка в статусе: долг', __METHOD__);
                $state = 5;
            }

            if ($checkPrim) {
                Yii::info('Заявка в статусе: замечение', __METHOD__);
                $state = 6;
            }
        }

        $app_eq->hire_state_id = $state;

        try {
            if (!$app_eq->save(false)) {
                Yii::error('Ошибка при сохранении состояния: ' . serialize($app_eq->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при сохранении состояния: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        Yii::info('Заявка успешно изменена', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Состояние успешно изменено'
        ];
    }
}