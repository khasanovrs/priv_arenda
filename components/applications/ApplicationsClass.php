<?php
/**
 * Управление заявками
 */

namespace app\components\applications;

use app\components\pay\PayClass;
use app\components\Session\Sessions;
use app\models\ApplicationEquipment;
use app\models\ApplicationPay;
use app\models\Applications;
use app\models\ApplicationsDelivery;
use app\models\ApplicationsField;
use app\models\ApplicationsShowField;
use app\models\ApplicationsSource;
use app\models\ApplicationsStatus;
use app\models\ApplicationsTypeLease;
use app\models\Branch;
use app\models\Clients;
use app\models\Discount;
use Yii;

class ApplicationsClass
{
    /**
     * Получение статусов заявок
     * @return bool|array
     */
    public static function GetApplicationsStatus()
    {
        Yii::info('Запуск функции GetApplicationsStatus', __METHOD__);
        $result = [];

        $list = ApplicationsStatus::find()->orderBy('id')->all();

        if (!is_array($list)) {
            Yii::error('Список статусов заявок пуст', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Список статусов заявок пуст'
            ];
        }

        /**
         * @var ApplicationsStatus $value
         */
        foreach ($list as $value) {
            $result[] = [
                'val' => $value->id,
                'name' => $value->name,
                'color' => $value->color
            ];
        }

        Yii::info('Список статусов заявок получен', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Список статусов заявок получен',
            'data' => $result
        ];
    }

    /**
     * Получение списка типов аренды
     * @return bool|array
     */
    public static function GetApplicationsTypeLease()
    {
        Yii::info('Запуск функции GetApplicationsTypeLease', __METHOD__);
        $result = [];

        $list = ApplicationsTypeLease::find()->orderBy('id')->all();

        if (!is_array($list)) {
            Yii::error('Список типов аренды пуст', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Список типов аренды пуст'
            ];
        }

        /**
         * @var ApplicationsTypeLease $value
         */
        foreach ($list as $value) {
            $result[] = [
                'val' => $value->id,
                'name' => $value->name
            ];
        }

        Yii::info('Список типов аренды получен', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Список типов аренды получен',
            'data' => $result
        ];
    }

    /**
     * Получение статусов источников
     * @return bool|array
     */
    public static function GetApplicationsSource()
    {
        Yii::info('Запуск функции GetApplicationsSource', __METHOD__);
        $result = [];

        $list = ApplicationsSource::find()->orderBy('id')->all();

        if (!is_array($list)) {
            Yii::error('Список источников заявок пуст', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Список источников заявок пуст'
            ];
        }

        /**
         * @var ApplicationsSource $value
         */
        foreach ($list as $value) {
            $result[] = [
                'val' => $value->id,
                'name' => $value->name
            ];
        }

        Yii::info('Список источников заявок получен', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Список источников заявок получен',
            'data' => $result
        ];
    }

    /**
     * Получение статусов доставки заявки
     * @return bool|array
     */
    public static function GetApplicationDelivery()
    {
        Yii::info('Запуск функции GetApplicationDelivery', __METHOD__);
        $result = [];

        $list = ApplicationsDelivery::find()->orderBy('id')->all();

        if (!is_array($list)) {
            Yii::error('Список статусов доставки заявок пуст', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Список статусов доставки заявок пуст'
            ];
        }

        /**
         * @var ApplicationsDelivery $value
         */
        foreach ($list as $value) {
            $result[] = [
                'val' => $value->id,
                'name' => $value->name
            ];
        }

        Yii::info('Список статусов доставки заявок получен', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Список статусов доставки заявок получен',
            'data' => $result
        ];
    }

    /**
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public static function GetApplicationsFields()
    {
        Yii::info('Запуск функции GetApplicationsFields', __METHOD__);
        $result = [];

        $applicationsFieldList = ApplicationsField::find()->orderBy('id')->all();

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
         * @var ApplicationsField $value
         */
        foreach ($applicationsFieldList as $value) {
            $check_flag = ApplicationsShowField::find()->where('applications_field_id=:applications_field_id and user_id=:user_id', [':applications_field_id' => $value->id, ':user_id' => $session->user_id])->orderBy('id')->one();

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
    public static function ChangeApplicationsFields($params)
    {
        Yii::info('Запуск функции ChangeApplicationsFields', __METHOD__);

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
            ApplicationsShowField::deleteAll('user_id=:user_id', [':user_id' => $session->user_id]);
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при очистке списка скрытых полей : ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        foreach ($params as $value) {
            if ($value->flag === 0) {

                $newVal = new ApplicationsShowField();
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
     * Обновлене статуса у заявки
     * @param $id
     * @param $status
     * @return array|bool
     */
    public static function UpdateApplicationsStatus($id, $status)
    {
        Yii::info('Запуск функции UpdateApplicationsStatus', __METHOD__);

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

        $check_status = ApplicationsStatus::find()->where('id=:id', [':id' => $status])->one();

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

        $applications->status_id = $status;

        try {
            if (!$applications->save(false)) {
                Yii::error('Ошибка при обновлении статуса заявки: ' . serialize($applications->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при обновлении статуса заявки: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        Yii::info('Статус заявки успешно изменен', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Статус заявки успешно изменен'
        ];
    }

    /**
     * Создание заявки
     * @param $client_id
     * @param $equipments
     * @param $typeLease
     * @param $sale
     * @param $rent_start
     * @param $rent_end
     * @param $delivery
     * @param $sum
     * @param $delivery_sum
     * @param $status
     * @param $comment
     * @param $branch
     * @return array|bool
     * @throws \yii\base\InvalidConfigException
     */
    public static function AddApplication($client_id, $equipments, $typeLease, $sale, $rent_start, $rent_end, $delivery, $sum, $delivery_sum, $status, $comment, $branch)
    {
        Yii::info('Запуск функции AddApplication', __METHOD__);

        if (!is_array($equipments)) {
            Yii::error('Нет списка оборудования', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Нет списка оборудования',
            ];
        }

        if ($client_id === '') {
            Yii::error('Не передан идентификатор клиента, client_id: ' . serialize($client_id), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не передан идентификатор клиента',
            ];
        }

        if ($typeLease === '') {
            Yii::error('Не передан идентификатор тип аренды, typeLease: ' . serialize($typeLease), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не передан идентификатор тип аренды',
            ];
        }

        if ($sale === '') {
            Yii::error('Не передан идентификатор скидки, sale: ' . serialize($sale), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не передан идентификатор скидки',
            ];
        }

        if ($rent_start === '') {
            Yii::error('Не передана дата начала аренды, rent_start: ' . serialize($rent_start), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не передана дата начала аренды',
            ];
        }

        if ($rent_end === '') {
            Yii::error('Не передана дата окончания аренды, rent_end: ' . serialize($rent_end), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не передана дата окончания аренды',
            ];
        }

        if ($delivery === '') {
            Yii::error('Не указан способ доставки, delivery: ' . serialize($delivery), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не указан способ доставки',
            ];
        }

        if ($delivery_sum === '') {
            Yii::error('Не указана сумма доставки, delivery_sum: ' . serialize($delivery_sum), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не указана сумма доставки',
            ];
        }

        if ($sum === '') {
            Yii::error('Не указана сумма, sum: ' . serialize($sum), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не указана сумма',
            ];
        }

        if ($status === '') {
            Yii::error('Не указан статус, status: ' . serialize($status), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не указан статус',
            ];
        }

        if ($branch === '') {
            Yii::error('Не передан идентификатор филиала, branch: ' . serialize($branch), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не передан идентификатор филиала',
            ];
        }

        $check = Clients::find()->where('id=:id', [':id' => $client_id])->one();
        if (!is_object($check)) {
            Yii::error('Клиент не найден, client_id: ' . serialize($client_id), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Клиент не найден',
            ];
        }

        $check = ApplicationsTypeLease::find()->where('id=:id', [':id' => $typeLease])->one();
        if (!is_object($check)) {
            Yii::error('Тип аренда не найден, typeLease: ' . serialize($typeLease), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Тип аренда не найден',
            ];
        }

        $check = Discount::find()->where('id=:id', [':id' => $sale])->one();
        if (!is_object($check)) {
            Yii::error('Тип скидки не найден, sale: ' . serialize($sale), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Тип скидки не найден',
            ];
        }

        $check = ApplicationsDelivery::find()->where('id=:id', [':id' => $delivery])->one();
        if (!is_object($check)) {
            Yii::error('Тип доставки не найден, delivery: ' . serialize($delivery), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Тип доставки не найден',
            ];
        }

        $check = ApplicationsStatus::find()->where('id=:id', [':id' => $status])->one();
        if (!is_object($check)) {
            Yii::error('Статус не найден, status: ' . serialize($status), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Статус не найден',
            ];
        }

        $check = Branch::find()->where('id=:id', [':id' => $branch])->one();
        if (!is_object($check)) {
            Yii::error('Филиал не найден, branch: ' . serialize($branch), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Филиал не найден',
            ];
        }

        /**
         * @var Sessions $Sessions
         */
        $Sessions = Yii::$app->get('Sessions');
        $session = $Sessions->getSession();

        $newApplications = new Applications();
        $newApplications->client_id = $client_id;
        $newApplications->user_id = $session->user_id;
        $newApplications->source_id = $client_id;
        $newApplications->discount_id = $sale;
        $newApplications->delivery_id = $delivery;
        $newApplications->type_lease_id = $typeLease;
        $newApplications->branch_id = $branch;
        $newApplications->comment = $comment;
        $newApplications->rent_start = $rent_start;
        $newApplications->rent_end = $rent_end;
        $newApplications->date_create = date('Y-m-d H:i:s');

        try {
            if (!$newApplications->save(false)) {
                Yii::error('Ошибка при добавлении заявки: ' . serialize($newApplications->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при добавлении заявки: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        foreach ($equipments as $value) {
            $newApplicationEquipment = new ApplicationEquipment();
            $newApplicationEquipment->application_id = $newApplications->id;
            $newApplicationEquipment->equipments_id = $value->id;
            $newApplicationEquipment->status_id = $status;
            $newApplicationEquipment->equipments_count = $value->count;
            $newApplicationEquipment->sum = $value->price;
            $newApplicationEquipment->delivery_sum = $delivery_sum;

            try {
                if (!$newApplicationEquipment->save(false)) {
                    Yii::error('Ошибка при добавлении списка оборудования: ' . serialize($newApplicationEquipment->getErrors()), __METHOD__);
                    return false;
                }
            } catch (\Exception $e) {
                Yii::error('Поймали Exception при добавлении списка оборудования: ' . serialize($e->getMessage()), __METHOD__);
                return false;
            }

            if ($sum !== '') {
                $checkApp = PayClass::AddPay($newApplicationEquipment->id, $sum);

                if (!is_array($checkApp) || !isset($checkApp['status']) || $checkApp['status'] != 'SUCCESS') {
                    Yii::error('Ошибка при добавлении платежа', __METHOD__);

                    return [
                        'status' => 'ERROR',
                        'msg' => 'Ошибка при добавлении платежа',
                    ];
                }
            }
        }

        Yii::info('Заявка успешно добавлена', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Заявка успешно добавлена'
        ];
    }

    /**
     * Получение детальной информации о заявке
     * @param $applicationId
     * @return array|bool
     * @throws \yii\base\InvalidConfigException
     */
    public static function getApplicationInfo($applicationId)
    {
        Yii::info('Запуск функции getApplicationInfo', __METHOD__);
        $result = [];

        if ($applicationId === '') {
            Yii::error('Не передан идентификатор заявки, applicationId: ' . serialize($applicationId), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не передан идентификатор клиента',
            ];
        }

        /**
         * @var ApplicationEquipment $applicationEq
         */
        $applicationEq = ApplicationEquipment::find()->where('id=:id', [':id' => $applicationId])->one();

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

        $payList = ApplicationPay::find()->where('application_equipment_id=:id', [':id' => $applicationEq->id])->all();

        $arrPay = [];
        if (!empty($payList)) {

            /**
             * @var ApplicationPay $pay
             */
            foreach ($payList as $pay) {
                $date = date('d.m.Y H:i:s', strtotime($pay->date_create));
                $user = $pay->user->fio;

                array_push($arrPay, ['date' => $date, 'user' => $user, 'sum' => $pay->sum]);
            }
        }

        /**
         * @var Applications $application
         */

        $result = [
            'id' => $application->id,
            'branch' => $application->branch_id,
            'delivery' => $application->delivery_id,
            'typeLease' => $application->type_lease_id,
            'sale' => $application->discount_id,
            'source' => $application->source_id,
            'comment' => $application->comment,
            'rent_start' => date('Y-m-d', strtotime($application->rent_start)),
            'rent_end' => date('Y-m-d', strtotime($application->rent_end)),
            'client_id' => $application->client->id,
            'client_fio' => $application->client->name,
            'client_phone' => $application->client->phone,
            'delivery_sum' => $applicationEq->delivery_sum,
            'sum' => $applicationEq->sum,
            'pay_list' => $arrPay
        ];

        $mark = $applicationEq->equipments->mark0->name;
        $model = $applicationEq->equipments->model;
        $category = $applicationEq->equipments->category->name;

        $result['equipments'] = [
            'id' => $applicationEq->id,
            'equipments_id' => $applicationEq->equipments_id,
            'name' => $category . ' ' . $mark . ' ' . $model,
            'count' => $applicationEq->equipments_count,
            'status' => $applicationEq->status_id,
            'photo' => $applicationEq->equipments->photo
        ];

        Yii::info('Получаем платежи', __METHOD__);

        $pay_list = [];

        $pay_list_arr = $applicationEq->applicationPays;

        if (empty($pay_list_arr)) {
            Yii::info('Платежей нет', __METHOD__);
        } else {
            /**
             * @var ApplicationPay $value
             */
            foreach ($pay_list_arr as $value) {
                $arr = [
                    'date' => date('d.m.Y H:i', strtotime($value->date_create)),
                    'user_id' => $value->user->fio,
                    'sum' => $value->sum
                ];

                array_push($pay_list, $arr);
            }
        }

        $result['pay_list'] = $pay_list;

        Yii::info('Заявка успешно получена', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Заявка успешно получена',
            'data' => $result
        ];
    }

    /**
     * Функция получения заявок
     * @param $status
     * @param $source
     * @param $branch
     * @param $date_start
     * @param $date_end
     * @return array
     */
    public static function getApplications($status, $source, $branch, $date_start, $date_end)
    {
        Yii::info('Запуск функции getApplications', __METHOD__);
        $result = [];
        $listFilter = [];
        $params = [];

        if ($status !== '' and $status !== null) {
            Yii::info('Параметр status: ' . serialize($status), __METHOD__);
            $listFilter[] = 'application_equipment.status_id=:status';
            $params[':status'] = $status;
        }

        if ($source !== '' and $source !== null) {
            Yii::info('Параметр status: ' . serialize($source), __METHOD__);
            $listFilter[] = 'source_id=:source';
            $params[':source'] = $source;
        }

        if ($date_start !== '' and $date_start !== null) {
            Yii::info('Параметр date_start: ' . serialize($date_start), __METHOD__);
            $listFilter[] = 'date_create>:date_start';
            $params[':date_start'] = $date_start . ' 00:00:00';
        }

        if ($date_end !== '' and $date_end !== null) {
            Yii::info('Параметр date_end: ' . serialize($date_end), __METHOD__);
            $listFilter[] = 'date_create<:date_end';
            $params[':date_end'] = $date_end . ' 23:59:59';
        }

        if ($branch !== '' and $branch !== null) {
            Yii::info('Параметр branch: ' . serialize($branch), __METHOD__);

            $listFilter[] = 'branch_id in (:branch_id)';
            $params[':branch_id'] = $branch;
        }

        if (!empty($listFilter)) {
            $applications = Applications::find()->joinWith('applicationEquipments')->where(implode(" and ", $listFilter), $params)->orderBy('id desc')->all();
        } else {
            $applications = Applications::find()->joinWith('applicationEquipments')->orderBy('id desc')->all();
        }

        if (!is_array($applications)) {
            Yii::info('Список заявок пуст', __METHOD__);

            return [
                'status' => 'SUCCESS',
                'msg' => 'Список заявок пуст'
            ];
        }

        /**
         * @var Applications $application
         */
        foreach ($applications as $application) {
            foreach ($application->applicationEquipments as $equipments) {

                if ($status !== '' and $status !== null && $equipments->status_id !== $status) {
                    continue;
                }

                $mark = $equipments->equipments->mark0->name;
                $model = $equipments->equipments->model;
                $category = $equipments->equipments->category->name;

                $result[] = [
                    'id' => $application->id,
                    'equipments_id' => $equipments->id,
                    'equipments_name' => $category . ' ' . $mark . ' ' . $model,
                    'equipments_count' => $equipments->equipments_count,
                    'status' => $equipments->status_id,
                    'color' => $equipments->status->color,
                    'client' => $application->client->name,
                    'phone' => $application->client->phone,
                    'typeLease' => $application->typeLease->name,
                    'source' => $application->source->name,
                    'comment' => $application->comment,
                    'user' => $application->user->fio,
                ];
            }
        }

        Yii::info('Заявки успешно получены', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Заявки успешно получены',
            'data' => $result
        ];
    }


    /**
     * Добавление нового статуса для заявки
     * @param $name
     * @param $color
     * @param $val
     * @return bool|array
     */
    public static function AddStatus($name, $color, $val)
    {
        Yii::info('Запуск функции добавления нового статуса для оборудования', __METHOD__);

        if ($name === '') {
            Yii::error('Ни передано наименование статуса, name:' . serialize($name), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ни передано наименование статуса',
            ];
        }

        if ($val !== '') {
            $new_status = ApplicationsStatus::find()->where('id=:id', [':id' => $val])->one();

            if (!is_object($new_status)) {
                Yii::error('Передан некорректный идентификатор, id:' . serialize($val), __METHOD__);

                return [
                    'status' => 'ERROR',
                    'msg' => 'Передан некорректный идентификатор',
                ];
            }
        } else {
            $new_status = new ApplicationsStatus();
        }

        $new_status->name = $name;
        $new_status->color = $color;

        try {
            if (!$new_status->save(false)) {
                Yii::error('Ошибка при добавлении нового статуса для заявки: ' . serialize($new_status->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при добавлении нового статуса для заявки: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        Yii::info('Статус для заявки успешно добавлен', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => $val === '' ? 'Статус для заявки успешно добавлен' : 'Статус для заявки успешно обновлен'
        ];
    }

    /**
     * Удаление статуса заявки
     * @param $id ,
     * @return bool|array
     */
    public static function DeleteStatus($id)
    {
        Yii::info('Запуск функции удаления статуса заявки', __METHOD__);

        if ($id === '') {
            Yii::error('Ни передано идентификатор статуса, id:' . serialize($id), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ни передан идентификатор статуса',
            ];
        }

        $check_status = ApplicationEquipment::find()->where('status_id=:status', [':status' => $id])->one();

        if (is_object($check_status)) {
            Yii::error('Данный статус нельзя удалить. Статус используется, id:' . serialize($id), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Данный статус нельзя удалить. Статус используется',
            ];
        }

        try {
            ApplicationsStatus::deleteAll('id=:id', array(':id' => $id));
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