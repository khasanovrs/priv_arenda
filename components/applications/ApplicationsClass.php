<?php
/**
 * Управление заявками
 */

namespace app\components\applications;

use app\components\Clients\ClientsClass;
use app\components\discount\DeliveryClass;
use app\components\equipments\EquipmentsClass;
use app\components\hire\HireClass;
use app\components\pay\PayClass;
use app\components\Session\Sessions;
use app\models\ApplicationEquipment;
use app\models\ApplicationPay;
use app\models\Applications;
use app\models\ApplicationsDelivery;
use app\models\ApplicationsField;
use app\models\ApplicationsShowField;
use app\models\ApplicationsStatus;
use app\models\ApplicationsTypeLease;
use app\models\ApplicationSum;
use app\models\ApplicationSumDelivery;
use app\models\Branch;
use app\models\Clients;
use app\models\Discount;
use app\models\Equipments;
use app\models\FinanceCashbox;
use app\models\Source;
use app\models\Users;
use Codeception\Application;
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

        if ($status === 1 || $status === 2) {
            $checkChange = EquipmentsClass::changeStatus($applications->equipments_id, $status === 1 ? 1 : 5);

            if (!is_array($checkChange) || !isset($checkChange['status']) || $checkChange['status'] != 'SUCCESS') {
                Yii::error('Ошибка при изменении статуса оборудования', __METHOD__);

                return [
                    'status' => 'ERROR',
                    'msg' => 'Ошибка при изменении статуса оборудования',
                ];
            }
        }

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
     * @param $source
     * @param $lesa
     * @param $month_sum
     * @param $square
     * @param $address
     * @return array|bool
     * @throws \yii\base\InvalidConfigException
     */
    public static function AddApplication($client_id, $equipments, $typeLease, $sale, $rent_start, $rent_end, $delivery, $sum, $delivery_sum, $status, $comment, $branch, $source, $lesa, $month_sum, $square, $address)
    {
        Yii::info('Запуск функции AddApplication', __METHOD__);

        if (empty($equipments)) {
            Yii::error('Нет списка оборудования', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Нет списка оборудования',
            ];
        }

        if ($status === '') {
            Yii::error('Не указан статус, status: ' . serialize($status), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не указан статус',
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

        if ($status === 1 || $status === 2) {
            if (!is_numeric($client_id)) {
                Yii::error('Не передан идентификатор клиента, client_id: ' . serialize($client_id), __METHOD__);

                return [
                    'status' => 'ERROR',
                    'msg' => 'Не передан идентификатор клиента',
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

            if (!is_numeric($typeLease)) {
                Yii::error('Не передан идентификатор тип аренды, typeLease: ' . serialize($typeLease), __METHOD__);

                return [
                    'status' => 'ERROR',
                    'msg' => 'Не передан идентификатор тип аренды',
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
        }

        if ($status === 3 && $client_id === null) {
            /**
             * @var Clients $client
             */
            $client = Clients::find()->where('branch_id=:branch_id and phone="79111111111"', [':branch_id' => $branch])->one();

            if (!is_object($client)) {
                $checkAdd = ClientsClass::AddClient('', '', 1, $branch, 2, 2, '', 6, '', '', '', 'Тестовы пользователь', 79111111111, '', '', '', '', '', 3);

                if (!is_array($checkAdd) || !isset($checkAdd['status']) || $checkAdd['status'] != 'SUCCESS') {
                    Yii::error('Ошибка при добавлении нового клиента', __METHOD__);

                    return [
                        'status' => 'ERROR',
                        'msg' => 'Ошибка при добавлении нового клинета',
                    ];
                }

                $client_id = $checkAdd['data']['id'];
            } else {
                $client_id = $client->id;
            }
        }

        if (!is_numeric($delivery)) {
            Yii::error('Не указан способ доставки, delivery: ' . serialize($delivery), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не указан способ доставки',
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

        if ($delivery_sum === '') {
            Yii::error('Не указана сумма доставки, delivery_sum: ' . serialize($delivery_sum), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не указана сумма доставки',
            ];
        }


        if (!is_numeric($source)) {
            Yii::error('Не передан источник, source: ' . serialize($source), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не передан идентификатор источник',
            ];
        }
        $check = Source::find()->where('id=:id', [':id' => $source])->one();
        if (!is_object($check)) {
            Yii::error('Источник не найден, source: ' . serialize($source), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Источник не найден',
            ];
        }

        if (!is_numeric($sale)) {
            Yii::error('Не передан идентификатор скидки, sale: ' . serialize($sale), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не передан идентификатор скидки',
            ];
        }

        /**
         * @var Discount $disc
         */
        $disc = Discount::find()->where('id=:id', [':id' => $sale])->one();
        if (!is_object($disc)) {
            Yii::error('Тип скидки не найден, sale: ' . serialize($sale), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Тип скидки не найден',
            ];
        }

        if ($sum === '') {
            Yii::error('Не указана сумма, sum: ' . serialize($sum), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не указана сумма',
            ];
        }

        if (!is_numeric($branch)) {
            Yii::error('Не передан идентификатор филиала, branch: ' . serialize($branch), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не передан идентификатор филиала',
            ];
        }

        /**
         * @var Branch $checkBranch
         */
        $checkBranch = Branch::find()->where('id=:id', [':id' => $branch])->one();
        if (!is_object($checkBranch)) {
            Yii::error('Филиал не найден, branch: ' . serialize($branch), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Филиал не найден',
            ];
        }

        $app_id = '';
        $delivery_id = 1;
        foreach ($equipments as $value) {
            /**
             * @var Sessions $Sessions
             */
            $Sessions = Yii::$app->get('Sessions');
            $session = $Sessions->getSession();

            /**
             * @var Equipments $equipment
             */
            $equipment = Equipments::find()->where('id=:id', [':id' => $value->id])->one();

            if (!is_object($equipment)) {
                Yii::info('Ошибка при получении оборудования', __METHOD__);

                return [
                    'status' => 'ERROR',
                    'msg' => 'Ошибка при получении оборудования'
                ];
            }

            if ($delivery_sum !== '' && $delivery_id === 1) {
                $newApplicationSumDelivery = new ApplicationSumDelivery();
                $newApplicationSumDelivery->delivery_sum = $delivery_sum;
                $newApplicationSumDelivery->delivery_sum_paid = 0;

                try {
                    if (!$newApplicationSumDelivery->save(false)) {
                        Yii::error('Ошибка при добавлении доставки: ' . serialize($newApplicationSumDelivery->getErrors()), __METHOD__);
                        return false;
                    }
                } catch (\Exception $e) {
                    Yii::error('Поймали Exception при добавлении доставки: ' . serialize($e->getMessage()), __METHOD__);
                    return false;
                }

                $delivery_id = $newApplicationSumDelivery->id;
            }

            if (($app_id === '' && $lesa) || !$lesa) {
                $dateDiff = strtotime($rent_end) - strtotime($rent_start);
                if ($lesa) {
                    $price = ($dateDiff / (60 * 60 * 24)) * ($month_sum / 30);
                    $sale_sum = $month_sum / 30;
                } else {
                    $price = ($dateDiff / (60 * 60 * 24)) * $equipment->price_per_day * (int)$value->count;
                    $sale_sum = $equipment->price_per_day;
                }

                if ((int)$disc->code !== 0) {
                    $sale_sum = $sale_sum - ($sale_sum * $disc->code / 100);
                    $price = $price - ($price * $disc->code / 100);
                }

                $newApplications = new Applications();
                $newApplications->client_id = $client_id !== '' ? $client_id : 0;
                $newApplications->user_id = $session->user_id;
                $newApplications->source_id = $source;
                $newApplications->discount_id = $sale;
                $newApplications->delivery_id = $delivery;
                $newApplications->type_lease_id = $typeLease;
                $newApplications->branch_id = $branch;
                $newApplications->comment = $comment;
                $newApplications->rent_start = $rent_start;
                $newApplications->rent_end = $rent_end;
                $newApplications->lesa = +$lesa;
                $newApplications->date_create = date('Y-m-d H:i:s');
                $newApplications->month_sum = $month_sum;
                $newApplications->square = $square;
                $newApplications->address = $address;
                $newApplications->delivery_sum_id = $delivery_id;
                $newApplications->sum = round($price);
                $newApplications->sum_sale = round($sale_sum);
                $newApplications->total_paid = 0;
                $newApplications->status_id = $status;
                $newApplications->hire_state_id = $status === 1 ? 4 : 1;
                $newApplications->equipments_status = $status === 1 ? 1 : 4;

                try {
                    if (!$newApplications->save(false)) {
                        Yii::error('Ошибка при добавлении заявки: ' . serialize($newApplications->getErrors()), __METHOD__);
                        return false;
                    }
                } catch (\Exception $e) {
                    Yii::error('Поймали Exception при добавлении заявки: ' . serialize($e->getMessage()), __METHOD__);
                    return false;
                }

                $app_id = $newApplications->id;
            }

            $newApplicationEquipment = new ApplicationEquipment();
            $newApplicationEquipment->application_id = $app_id;
            $newApplicationEquipment->equipments_id = $value->id;
            $newApplicationEquipment->equipments_count = $value->count;

            try {
                if (!$newApplicationEquipment->save(false)) {
                    Yii::error('Ошибка при добавлении списка оборудования: ' . serialize($newApplicationEquipment->getErrors()), __METHOD__);
                    return false;
                }
            } catch (\Exception $e) {
                Yii::error('Поймали Exception при добавлении списка оборудования: ' . serialize($e->getMessage()), __METHOD__);
                return false;
            }

            if ($lesa) {
                Yii::info('Прокат лесов, уменьшаем количество', __METHOD__);

                $equipment->count_hire = (int)$equipment->count_hire + (int)$value->count;
                try {
                    if (!$equipment->save(false)) {
                        Yii::error('Ошибка при сохранении количества оборудования: ' . serialize($equipment->getErrors()), __METHOD__);
                        return false;
                    }
                } catch (\Exception $e) {
                    Yii::error('Поймали Exception при сохранении количества оборудования: ' . serialize($e->getMessage()), __METHOD__);
                    return false;
                }
            }

            Yii::info('Добавляем платежи', __METHOD__);

            if (count($value->payList) !== 0) {
                Yii::info('Добавляем платежи', __METHOD__);

                foreach ($value->payList as $valueSecond) {
                    $checkApp = PayClass::AddPay($app_id, $valueSecond->sum, $valueSecond->cashBox, $valueSecond->revertSum);

                    if (!is_array($checkApp) || !isset($checkApp['status']) || $checkApp['status'] != 'SUCCESS') {
                        Yii::error('Ошибка при добавлении платежа', __METHOD__);

                        if (is_array($checkApp) && isset($checkApp['status']) && $checkApp['status'] === 'ERROR') {
                            return $checkApp;
                        }

                        return [
                            'status' => 'ERROR',
                            'msg' => 'Ошибка при добавлении платежа',
                        ];
                    }
                }
            }

            Yii::info('Опраделеяем статус для оборудования', __METHOD__);

            if ($status === 1 || $status === 2) {
                $checkChange = EquipmentsClass::changeStatus($value->id, $status === 1 ? 1 : 5, $rent_start, $rent_end);

                if (!is_array($checkChange) || !isset($checkChange['status']) || $checkChange['status'] != 'SUCCESS') {
                    Yii::error('Ошибка при изменении статуса оборудования', __METHOD__);

                    return [
                        'status' => 'ERROR',
                        'msg' => 'Ошибка при изменении статуса оборудования',
                    ];
                }
            }

            Yii::info('Правим статусы у прокатов', __METHOD__);

            $check = HireClass::checkHire($app_id);

            if (!is_array($check) || !isset($check['status']) || $check['status'] != 'SUCCESS') {
                Yii::error('Ошибка при определии статуса', __METHOD__);

                return [
                    'status' => 'ERROR',
                    'msg' => 'Ошибка при изменении состояния',
                ];
            }

            Yii::info('Заявка успешно добавлена', __METHOD__);
        }

        return [
            'status' => 'SUCCESS',
            'msg' => 'Заявка успешно добавлена'
        ];
    }

    /**
     * Получение детальной информации о заявке
     * @param $applicationId
     * @return array
     */
    public static function getApplicationInfo($applicationId)
    {
        Yii::info('Запуск функции getApplicationInfo', __METHOD__);

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

        Yii::info('Получаем платежи', __METHOD__);

        $pay_list = PayClass::getPayList($application->id);

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

        /**
         * @var Applications $application
         */

        $client = ClientsClass::GetClientInfo($application->client_id);

        $result = [
            'id' => $application->id,
            'branch' => $application->branch->name,
            'delivery' => $application->delivery_id,
            'typeLease' => $application->type_lease_id,
            'sale' => $application->discount_id,
            'source' => $application->source_id,
            'comment' => $application->comment,
            'rent_start' => date('Y-m-d', strtotime($application->rent_start)),
            'rent_end' => date('Y-m-d', strtotime($application->rent_end)),
            'client_id' => $client->id,
            'client_fio' => $client->name,
            'client_phone' => $client->phone,
            // 'delivery_sum' => $applicationEq->delivery_sum, @todo сделать
            'sum' => $application->sum,
            'pay_list' => $pay_list,
            'date_create' => date('d.m.Y H:i:s', strtotime($application->date_create)),
        ];

        $mark = $applicationEq->equipments->mark0->name;
        $model = $applicationEq->equipments->model;
        $category = $applicationEq->equipments->category->name;

        $result['equipments'] = [
            'id' => $applicationEq->id,
            'equipments_id' => $applicationEq->equipments_id,
            'name' => $category . ' ' . $mark . ' ' . $model,
            'count' => $applicationEq->equipments_count,
            'status' => $application->status_id,
            'photo' => $applicationEq->equipments->photo,
            'photo_alias' => $applicationEq->equipments->photo_alias
        ];

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
     * @throws \yii\base\InvalidConfigException
     */
    public static function getApplications($status, $source, $branch, $date_start, $date_end)
    {
        Yii::info('Запуск функции getApplications', __METHOD__);
        $result = [];
        $listFilter = [];
        $params = [];
        $stockUser = '';

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
         * @var Users $user
         */
        $user = Users::find()->where('id=:id', [':id' => $session->user_id])->one();

        if (!is_object($user)) {
            Yii::error('Пользователь не найден', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Пользователь не найден',
            ];
        }

        if ($user->user_type === 2) {
            $stockUserObject = $user->branch;

            if (!is_object($stockUserObject)) {
                Yii::error('Ошибка при определении филиала у менеджера' . serialize($stockUser), __METHOD__);

                return [
                    'status' => 'ERROR',
                    'msg' => 'Ошибка при определении филиала у менеджера',
                ];
            }

            $stockUser = $stockUserObject->id;
        }

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

        if ($stockUser !== '') {
            $listFilter[] = 'is_not_active=0 and branch_id=' . $stockUser;
        } else {
            $listFilter[] = 'is_not_active=0';
        }

        if (!empty($listFilter)) {
            $applications = Applications::find()->joinWith('applicationEquipments')->where(implode(" and ", $listFilter), $params)->orderBy('id desc')->all();
        } else {
            $applications = Applications::find()->joinWith('applicationEquipments')->where(implode(" and ", $listFilter))->orderBy('id desc')->all();
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

                if ($status !== '' and $status !== null && $application->status_id !== $status) {
                    continue;
                }

                $mark = $equipments->equipments->mark0->name;
                $model = $equipments->equipments->model;
                $type = $equipments->equipments->type0->name;
                $client = ClientsClass::GetClientInfo($application->client_id);

                $result[] = [
                    'id' => $application->id,
                    'equipments_id' => $equipments->id,
                    'equipments_name' => $type . ' ' . $mark . ' ' . $model,
                    'equipments_count' => $equipments->equipments_count,
                    'status' => $application->status_id,
                    'color' => $application->status->color,
                    'client' => $client->name,
                    'branch' => $application->branch->name,
                    'phone' => $client->phone,
                    'typeLease' => $application->typeLease->name,
                    'source' => $application->source->name,
                    'comment' => $application->comment,
                    'user' => $application->user->fio,
                    'date_create' => $application->date_create,
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