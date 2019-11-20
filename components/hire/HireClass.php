<?php
/**
 * Управление прокатом
 */

namespace app\components\hire;

use app\components\Clients\ClientsClass;
use app\components\equipments\EquipmentsClass;
use app\components\pay\PayClass;
use app\components\Session\Sessions;
use app\models\ApplicationEquipment;
use app\models\ApplicationPay;
use app\models\Applications;
use app\models\Equipments;
use app\models\Extension;
use app\models\HireField;
use app\models\HireLesaField;
use app\models\HireLesaShowField;
use app\models\HireShowField;
use app\models\HireState;
use app\models\HireStatus;
use app\models\Users;
use Yii;

class HireClass
{
    /**
     * Получение активныйх полей проката
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
     * Получение активныйх полей проката лесов
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public static function GetHireLesaFields()
    {
        Yii::info('Запуск функции GetHireLesaFields', __METHOD__);
        $result = [];

        $applicationsFieldList = HireLesaField::find()->orderBy('id')->all();

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
            $check_flag = HireLesaShowField::find()->where('hire_field_id=:hire_field_id and user_id=:user_id', [':hire_field_id' => $value->id, ':user_id' => $session->user_id])->orderBy('id')->one();

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
     * Изменение активных полей для проката
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
     * Изменение активных полей для проката лесов
     * @param $params
     * @return array|bool
     * @throws \yii\base\InvalidConfigException
     */
    public static function ChangeHireLesaFields($params)
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
            HireLesaShowField::deleteAll('user_id=:user_id', [':user_id' => $session->user_id]);
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при очистке списка скрытых полей : ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        foreach ($params as $value) {
            if ($value->flag === 0) {

                $newVal = new HireLesaShowField();
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
     * Получение списка прокатов
     * @param $status
     * @param $like
     * @param $branch
     * @param $date_start
     * @param $date_end
     * @param $show_close_hire
     * @param $lesa
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public static function GetHire($status, $like, $branch, $date_start, $date_end, $show_close_hire, $lesa)
    {
        Yii::info('Запуск функции GetHire', __METHOD__);
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

        if ($show_close_hire === '0') {
            Yii::info('Параметр show_close_hire: ' . serialize($show_close_hire), __METHOD__);
            $listFilter[] = 'hire_state_id!=3';
        }

        if ($stockUser !== '') {
            $listFilter[] = 'applications.is_not_active=0 and status_id in (1,2) and applications.branch_id=' . $stockUser;
        } else {
            $listFilter[] = 'applications.is_not_active=0 and status_id in (1,2)';
        }

        $listFilter[] = $lesa ? 'applications.lesa=1' : 'applications.lesa=0';


        if (!empty($listFilter)) {
            $list = ApplicationEquipment::find()->joinWith(['application', 'equipments', 'equipments.mark0', 'equipments.type0'])->leftJoin('clients', '`clients`.`id` = `applications`.`client_id`')->where(implode(" and ", $listFilter), $params)->orderBy('id desc')->all();
        } else {
            $list = ApplicationEquipment::find()->joinWith(['application'])->where(implode(" and ", $listFilter))->orderBy('id desc')->all();
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

        if (!$lesa) {
            foreach ($list as $value) {
                /**
                 * @var Applications $application
                 */
                $application = $value->application;

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
                $sumCurrentDay = ApplicationPay::find()->joinWith('cashBox0')->where('finance_cashbox.check_zalog=0 and finance_cashbox.delivery=0 and application_equipment_id=:id and date_create like :date', [':id' => $value->id, ':date' => $date_cr . '%'])->sum('application_pay.sum');

                $mark = $value->equipments->mark0->name;
                $model = $value->equipments->model;
                $type = $value->equipments->type0->name;

                $client = ClientsClass::GetClientInfo($application->client_id);

                $result[] = [
                    'id' => $value->id,
                    'app_id' => $application->id,
                    'typeLease_id' => $application->type_lease_id,
                    'client' => $client->name,
                    'client_phone' => $client->phone,
                    'equipments' => $type . ' ' . $mark . ' ' . $model,
                    'start_hire' => date('d.m.Y H:i:s', strtotime($application->rent_start)),
                    'end_hire' => date('d.m.Y H:i:s', strtotime($application->rent_end)),
                    'status' => $value->hire_status_id,
                    'state' => $value->hireState->name,
                    'color' => $value->hireStatus->color,
                    'sum' => $value->equipments->price_per_day, // цена оборудования
                    'sum_hire' => $value->sum, // сумма аренды со скдикой
                    'sale_sum' => $value->sum_sale, // общая сумма со скидкой
                    'total_paid' => $value->total_paid, // всего оплачено
                    'remainder' => (float)$value->sum - (float)$value->total_paid, // остаток
                    'date_create' => date('d.m.Y H:i:s', strtotime($application->date_create)),
                    'comment' => $application->comment,
                    'date_end' => $application->date_end,
                    'branch' => $application->branch->name,
                    'delivery_sum' => $value->delivery_sum,
                    'delivery_sum_paid' => $value->delivery_sum_paid,
                    'current_pay' => (float)$sumCurrentDay
                ];
            }
        } else {
            foreach ($list as $value) {
                $rama_prokhodnaya = 0;
                $rama_letsnitsey = 0;
                $diagonalnaya_svyaz = 0;
                $gorizontalnaya_svyaz = 0;
                $rigel = 0;
                $nastil = 0;

                /**
                 * @var Applications $application
                 */
                $application = $value->application;

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
                $sumCurrentDay = ApplicationPay::find()->joinWith('cashBox0')->where('finance_cashbox.check_zalog=0 and finance_cashbox.delivery=0 and application_equipment_id=:id and date_create like :date', [':id' => $value->id, ':date' => $date_cr . '%'])->sum('application_pay.sum');

                $client = ClientsClass::GetClientInfo($application->client_id);

                $keyArr = '';
                foreach ($result as $key => $item) {
                    if ($item['app_id'] === $application->id) {
                        $keyArr = $key;
                    }
                }

                Yii::info('Определяем тип', __METHOD__);
                $type = $value->equipments->type0->name;

                if ($type == 'Рама проходная') {
                    $rama_prokhodnaya = $value->equipments_count;
                } elseif ($type == 'Рама с лестницей') {
                    $rama_letsnitsey = $value->equipments_count;
                } elseif ($type == 'Диагональная связь') {
                    $diagonalnaya_svyaz = $value->equipments_count;
                } elseif ($type == 'Горизонтальная связь') {
                    $gorizontalnaya_svyaz = $value->equipments_count;
                } elseif ($type == 'Ригель') {
                    $rigel = $value->equipments_count;
                } elseif ($type == 'Настил') {
                    $nastil = $value->equipments_count;
                }

                if ($keyArr === '') {
                    $result[] = [
                        'id' => $value->id,
                        'app_id' => $application->id,
                        'typeLease_id' => $application->type_lease_id,
                        'client' => $client->name,
                        'client_phone' => $client->phone,
                        'equipments' => 'Леса',
                        'start_hire' => date('d.m.Y H:i:s', strtotime($application->rent_start)),
                        'end_hire' => date('d.m.Y H:i:s', strtotime($application->rent_end)),
                        'status' => $value->hire_status_id,
                        'state' => $value->hireState->name,
                        'color' => $value->hireStatus->color,
                        'sum' => $application->month_sum, // цена оборудования
                        'sum_hire' => $value->sum, // сумма аренды со скдикой
                        'sale_sum' => $value->sum_sale, // общая сумма со скидкой
                        'total_paid' => $value->total_paid, // всего оплачено
                        'remainder' => (float)$value->sum - (float)$value->total_paid, // остаток
                        'date_create' => date('d.m.Y H:i:s', strtotime($application->date_create)),
                        'comment' => $application->comment,
                        'date_end' => $application->date_end,
                        'branch' => $application->branch->name,
                        'delivery_sum' => $value->delivery_sum,
                        'delivery_sum_paid' => $value->delivery_sum_paid,
                        'current_pay' => (float)$sumCurrentDay,
                        'rama_prokhodnaya' => $rama_prokhodnaya != 0 ? $rama_prokhodnaya : 0,
                        'rama_letsnitsey' => $rama_letsnitsey != 0 ? $rama_letsnitsey : 0,
                        'diagonalnaya_svyaz' => $diagonalnaya_svyaz != 0 ? $diagonalnaya_svyaz : 0,
                        'gorizontalnaya_svyaz' => $gorizontalnaya_svyaz != 0 ? $gorizontalnaya_svyaz : 0,
                        'rigel' => $rigel != 0 ? $rigel : 0,
                        'nastil' => $nastil != 0 ? $nastil : 0,
                        'square' => $application->square,
                    ];
                } else {
                    $result[$keyArr]['rama_prokhodnaya'] = $rama_prokhodnaya != 0 ? $rama_prokhodnaya : $result[$keyArr]['rama_prokhodnaya'];
                    $result[$keyArr]['rama_letsnitsey'] = $rama_letsnitsey != 0 ? $rama_letsnitsey : $result[$keyArr]['rama_letsnitsey'];
                    $result[$keyArr]['diagonalnaya_svyaz'] = $diagonalnaya_svyaz != 0 ? $diagonalnaya_svyaz : $result[$keyArr]['diagonalnaya_svyaz'];
                    $result[$keyArr]['gorizontalnaya_svyaz'] = $gorizontalnaya_svyaz != 0 ? $gorizontalnaya_svyaz : $result[$keyArr]['gorizontalnaya_svyaz'];
                    $result[$keyArr]['rigel'] = $rigel != 0 ? $rigel : $result[$keyArr]['rigel'];
                    $result[$keyArr]['nastil'] = $nastil != 0 ? $nastil : $result[$keyArr]['nastil'];
                    $result[$keyArr]['total_paid'] = $result[$keyArr]['total_paid'] + $value->total_paid; // всего оплачено
                    $result[$keyArr]['remainder'] = $result[$keyArr]['sum_hire'] - $result[$keyArr]['total_paid']; // остаток
                }
            }
        }

        Yii::info('Список прокатов получен' . serialize($result), __METHOD__);

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

        $client = ClientsClass::GetClientInfo($application->client_id);

        $mark = $applicationEq->equipments->mark0->name;
        $model = $applicationEq->equipments->model;
        $category = $applicationEq->equipments->category->name;

        $pay_list = PayClass::getPayList($application->id, $application->lesa, $applicationEq->id);

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
            'hire_state_id' => $applicationEq->hire_state_id,
            'hire_state' => $applicationEq->hireState->name,
            'source' => $application->source->name,
            'comment' => $application->comment,
            'rent_start' => $application->rent_start,
            'rent_end' => $application->rent_end,
            'client_fio' => $client->name,
            'client_phone' => $client->phone,
            'delivery_sum' => $applicationEq->delivery_sum,
            'sum' => $applicationEq->sum,
            'total_paid' => $application->lesa === '1' ? 0 : $applicationEq->total_paid,
            'remainder' => $application->lesa === '1' ? 0 : $applicationEq->sum - $applicationEq->total_paid,
            'count' => 0,
            'equipments' =>
                [
                    'equipments_id' => $applicationEq->equipments_id,
                    'name' => $category . ' ' . $mark . ' ' . $model,
                    'state' => $applicationEq->equipments->status0->name,
                    'state_id' => $applicationEq->equipments->status,
                    'photo' => $applicationEq->equipments->photo,
                    'photo_alias' => $applicationEq->equipments->photo_alias
                ],
            'extensions' => $extensions_list['data'],
            'pay_list' => $pay_list['data'],
            'lesa' => $application->lesa,
            'rama_prokhodnaya' => 0,
            'rama_letsnitsey' => 0,
            'diagonalnaya_svyaz' => 0,
            'gorizontalnaya_svyaz' => 0,
            'rigel' => 0,
            'nastil' => 0,
            'month_sum' => $application->month_sum,
            'square' => $application->square,
            'address' => $application->address,
        ];

        if ($application->lesa === '1') {
            $result['equipments']['name'] = 'Леса';

            $list = ApplicationEquipment::find()->joinWith(['application'])->where('application_id=:application_id', [':application_id' => $application->id])->orderBy('id desc')->all();

            if (!empty($list)) {

                /**
                 * @var ApplicationEquipment $value
                 */
                foreach ($list as $value) {
                    $type = $value->equipments->type0->name;

                    if ($type == 'Рама проходная') {
                        $result['rama_prokhodnaya'] = $value->equipments_count;
                    } elseif ($type == 'Рама с лестницей') {
                        $result['rama_letsnitsey'] = $value->equipments_count;
                    } elseif ($type == 'Диагональная связь') {
                        $result['diagonalnaya_svyaz'] = $value->equipments_count;
                    } elseif ($type == 'Горизонтальная связь') {
                        $result['gorizontalnaya_svyaz'] = $value->equipments_count;
                    } elseif ($type == 'Ригель') {
                        $result['rigel'] = $value->equipments_count;
                    } elseif ($type == 'Настил') {
                        $result['nastil'] = $value->equipments_count;
                    }

                    $result['total_paid'] += (float)$value->total_paid; // всего оплачено
                    $result['remainder'] = $result['sum'] - $result['total_paid']; // остаток
                }
            }
        }

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

        $app = $applicationEq->application;
        $app->comment = $comment;

        try {
            if (!$app->save(false)) {
                Yii::error('Ошибка при изменении заявки: ' . serialize($app->getErrors()), __METHOD__);
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
     * Продление проката
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

        $app_eq = $applications->applicationEquipments;

        if (empty($app_eq)) {
            Yii::info('Ошибка при получении заявки с оборудованием', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при получении заявки с оборудованием'
            ];
        }

        /**
         * @var ApplicationEquipment $value
         */
        foreach ($app_eq as $value) {
            Yii::info('Получаем оборудование', __METHOD__);

            /**
             * @var Equipments $equipments
             */
            $equipments = $value->equipments;

            if (!is_object($equipments)) {
                Yii::info('Ошибка при получении оборудования', __METHOD__);

                return [
                    'status' => 'ERROR',
                    'msg' => 'Ошибка при получении оборудования'
                ];
            }

            $datediff = strtotime($applications->rent_end) - strtotime($applications->rent_start);
            $price = ($datediff / (60 * 60 * 24)) * $equipments->price_per_day * $value->equipments_count;

            if ((int)$applications->discount->code !== 0) {
                $price = $price - ($price * $applications->discount->code / 100);
            }

            $value->sum = round($price);
            $value->hire_state_id = 4;
            $value->renewals_date = date('Y-m-d H:i:s');

            Yii::info('Сохраняем сумму, сумма: ' . serialize($price), __METHOD__);

            try {
                if (!$value->save(false)) {
                    Yii::error('Ошибка при сохранении новой суммы: ' . serialize($value->getErrors()), __METHOD__);
                    return false;
                }
            } catch (\Exception $e) {
                Yii::error('Поймали Exception при сохранении новой суммы: ' . serialize($e->getMessage()), __METHOD__);
                return false;
            }

            $check = self::checkHire($value->id);

            if (!is_array($check) || !isset($check['status']) || $check['status'] != 'SUCCESS') {
                Yii::error('Ошибка при продлении контракта', __METHOD__);

                return [
                    'status' => 'ERROR',
                    'msg' => 'Ошибка при изменении состояния',
                ];
            }
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
        $extension->type = $applications->type_lease_id;
        $extension->application_equipment_id = $value->id;

        try {
            if (!$extension->save(false)) {
                Yii::error('Ошибка при сохранении продления: ' . serialize($extension->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при сохранении продления: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        Yii::info('Заявка успешно изменена', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Заявка успешно изменена'
        ];
    }

    /**
     * Сокращение проката
     * @param $app_eq_id
     * @param $app_id
     * @param $count
     * @return array|bool
     * @throws \yii\base\InvalidConfigException
     */
    public static function TameRental($app_eq_id, $app_id, $count)
    {
        Yii::info('Запуск функции TameRental', __METHOD__);

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
            $date = date("Y-m-d H:i:s", strtotime($applications->rent_end . " -" . $count . " days"));
        } else {
            $date = date("Y-m-d H:i:s", strtotime($applications->rent_end . " -" . $count . " month"));
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


        $app_eq = $applications->applicationEquipments;

        if (empty($app_eq)) {
            Yii::info('Ошибка при получении заявки с оборудованием', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при получении заявки с оборудованием'
            ];
        }

        /**
         * @var ApplicationEquipment $value
         */
        foreach ($app_eq as $value) {
            Yii::info('Получаем оборудование', __METHOD__);

            /**
             * @var Equipments $equipments
             */
            $equipments = $value->equipments;

            if (!is_object($equipments)) {
                Yii::info('Ошибка при получении оборудования', __METHOD__);

                return [
                    'status' => 'ERROR',
                    'msg' => 'Ошибка при получении оборудования'
                ];
            }

            $datediff = strtotime($applications->rent_end) - strtotime($applications->rent_start);
            $price = ($datediff / (60 * 60 * 24)) * $equipments->price_per_day * $value->equipments_count;

            if ((int)$applications->discount->code !== 0) {
                $price = $price - ($price * $applications->discount->code / 100);
            }

            $value->sum = round($price);

            Yii::info('Сохраняем сумму, сумма: ' . serialize($price), __METHOD__);

            try {
                if (!$value->save(false)) {
                    Yii::error('Ошибка при сохранении новой суммы: ' . serialize($value->getErrors()), __METHOD__);
                    return false;
                }
            } catch (\Exception $e) {
                Yii::error('Поймали Exception при сохранении новой суммы: ' . serialize($e->getMessage()), __METHOD__);
                return false;
            }

            $check = self::checkHire($value->id);

            if (!is_array($check) || !isset($check['status']) || $check['status'] != 'SUCCESS') {
                Yii::error('Ошибка при продлении контракта', __METHOD__);

                return [
                    'status' => 'ERROR',
                    'msg' => 'Ошибка при изменении состояния',
                ];
            }
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
        $extension->type = $applications->type_lease_id;
        $extension->application_equipment_id = $value->id;

        try {
            if (!$extension->save(false)) {
                Yii::error('Ошибка при сохранении продления: ' . serialize($extension->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при сохранении продления: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        Yii::info('Заявка успешно изменена', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Заявка успешно изменена'
        ];
    }

    /**
     * Функция возврата оборудования на склад
     * @param $app_id
     * @return array|bool
     */
    public static function equipmentReturn($app_id)
    {
        Yii::info('Запуск функции equipmentReturn', __METHOD__);

        if ($app_id === '') {
            Yii::error('Не передан идентификатор заявки', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не передан идентификатор заявки',
            ];
        }

        /**
         * @var ApplicationEquipment $app_eq
         */
        $app_eq = ApplicationEquipment::find()->where('id=:id', [':id' => $app_id])->one();

        if (!is_object($app_eq)) {
            Yii::info('Информация об оборудовании по заявке не найдена', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Заявка не найдена'
            ];
        }

        $checkChangeStatus = EquipmentsClass::changeStatus($app_eq->equipments_id, 4);

        if (!is_array($checkChangeStatus) || !isset($checkChangeStatus['status']) || $checkChangeStatus['status'] != 'SUCCESS') {
            Yii::error('Ошибка при изменении статуса', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при изменении статуса',
            ];
        }

        $hire_state_id = '';

        // долг - прокат не продлен, оборудование возвращено, но есть долг по оплате
        if ($app_eq->sum > $app_eq->total_paid && $app_eq->equipments->status === 4) {
            $hire_state_id = 5;
        }

        if ($hire_state_id !== '') {
            $app_eq->hire_state_id = $hire_state_id;

            try {
                if (!$app_eq->save(false)) {
                    Yii::error('Ошибка при закрытии проката: ' . serialize($app_eq->getErrors()), __METHOD__);
                    return false;
                }
            } catch (\Exception $e) {
                Yii::error('Поймали Exception при закрытии проката: ' . serialize($e->getMessage()), __METHOD__);
                return false;
            }
        }

        Yii::info('Оборудование успешно вернули', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Оборудование успешно вернули'
        ];
    }

    /**
     * Функция возврата лесов на склад
     * @param $app_id
     * @return array|bool
     */
    public static function lesaReturn($app_id)
    {
        Yii::info('Запуск функции equipmentReturn', __METHOD__);

        if ($app_id === '') {
            Yii::error('Не передан идентификатор заявки', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не передан идентификатор заявки',
            ];
        }

        /**
         * @var Applications $app
         */
        $app = Applications::find()->where('id=:id', [':id' => $app_id])->one();

        if (!is_object($app)) {
            Yii::info('Информация по заявке не найдена', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Заявка не найдена'
            ];
        }

        $app_eq = ApplicationEquipment::find()->where('application_id=:id', [':id' => $app->id])->all();

        if (!empty($app_eq)) {

            /**
             * @var ApplicationEquipment $value
             */

            $allSum = 0;
            $allTotalPaid = 0;
            foreach ($app_eq as $value) {
                $allSum += (float)$value->sum;
                $allTotalPaid += (float)$value->total_paid;
            }

            $allSum = $allSum / count($app_eq);

            foreach ($app_eq as $value) {
                $checkChangeStatus = EquipmentsClass::changeStatus($value->equipments_id, 4);

                if (!is_array($checkChangeStatus) || !isset($checkChangeStatus['status']) || $checkChangeStatus['status'] != 'SUCCESS') {
                    Yii::error('Ошибка при изменении статуса', __METHOD__);

                    return [
                        'status' => 'ERROR',
                        'msg' => 'Ошибка при изменении статуса',
                    ];
                }

                $hire_state_id = '';

                // долг - прокат не продлен, оборудование возвращено, но есть долг по оплате
                if ($allSum > $allTotalPaid && $value->equipments->status === 4) {
                    $hire_state_id = 5;
                }

                if ($hire_state_id !== '') {
                    $value->hire_state_id = $hire_state_id;

                    try {
                        if (!$value->save(false)) {
                            Yii::error('Ошибка при закрытии проката: ' . serialize($value->getErrors()), __METHOD__);
                            return false;
                        }
                    } catch (\Exception $e) {
                        Yii::error('Поймали Exception при закрытии проката: ' . serialize($e->getMessage()), __METHOD__);
                        return false;
                    }
                }

                Yii::info('Увеличиваем количество оборудования', __METHOD__);

                $eq = $value->equipments;
                $eq->count_hire -= $value->equipments_count;

                try {
                    if (!$eq->save(false)) {
                        Yii::error('Ошибка при сохранении количества проката: ' . serialize($eq->getErrors()), __METHOD__);
                        return false;
                    }
                } catch (\Exception $e) {
                    Yii::error('Поймали Exception при закрытии проката: ' . serialize($e->getMessage()), __METHOD__);
                    return false;
                }
            }
        }

        Yii::info('Оборудование успешно вернули', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Оборудование успешно вернули'
        ];
    }

    /**
     * Удаление проката
     * @param $app_id
     * @return array|bool
     */
    public static function deleteHire($app_id)
    {
        Yii::info('Запуск функции deleteHire', __METHOD__);

        if ($app_id === '') {
            Yii::error('Не передан идентификатор заявки', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не передан идентификатор заявки',
            ];
        }

        /**
         * @var Applications $applications
         */
        $applications = Applications::find()->where('id=:id', [':id' => $app_id])->one();

        if (!is_object($applications)) {
            Yii::info('Ошибка при получении оборудования', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при получении оборудования'
            ];
        }

        $applications->is_not_active = 1;

        try {
            if (!$applications->save(false)) {
                Yii::error('Ошибка при удалении проката: ' . serialize($applications->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при удалении проката: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        $app_eq = $applications->applicationEquipments;

        if (!empty($app_eq)) {
            /**
             * @var ApplicationEquipment $value
             */
            foreach ($app_eq as $value) {
                $eq = $value->equipments;

                $eq->status = 4;

                if ($applications->lesa === '1') {
                    $eq->count_hire -= $value->equipments_count;
                    $eq->count_hire = $eq->count_hire < 0 ? 0 : $eq->count_hire;
                }

                try {
                    if (!$eq->save(false)) {
                        Yii::error('Ошибка при изменении статуса проката: ' . serialize($eq->getErrors()), __METHOD__);
                        return false;
                    }
                } catch (\Exception $e) {
                    Yii::error('Поймали Exception изменении статуса проката: ' . serialize($e->getMessage()), __METHOD__);
                    return false;
                }
            }
        }

        Yii::info('Прокат успешно удален', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Прокат успешно удален'
        ];
    }

    /**
     * Закрытие проката
     * @param $app_id
     * @return array|bool
     */
    public static function closeHire($app_id)
    {
        Yii::info('Запуск функции closeHire', __METHOD__);

        if ($app_id === '') {
            Yii::error('Не передан идентификатор заявки', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не передан идентификатор заявки',
            ];
        }

        $check = self::checkHire($app_id);

        if (!is_array($check) || !isset($check['status']) || $check['status'] != 'SUCCESS') {
            Yii::error('Ошибка при продлении контракта', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при изменении состояния',
            ];
        }

        Yii::info('Прокат успешно закрыт', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => $check['msg']
        ];
    }

    /**
     * Проверка и изменение состояния у проката
     * @param $ap_eq_id
     * @return array|bool
     */
    public static function checkHire($ap_eq_id)
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

        $app = $app_eq->application;

        if (!is_object($app)) {
            Yii::info('Информация о заявке не найдена', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Заявка не найдена'
            ];
        }

        if ($app->lesa === '1') {
            $app_eq = ApplicationEquipment::find()->where('application_id=:id', [':id' => $app->id])->all();
            if (empty($app_eq)) {
                Yii::info('Оборудования у лесов не найдены', __METHOD__);

                return [
                    'status' => 'ERROR',
                    'msg' => 'Оборудования у лесов не найдены'
                ];
            }

            /**
             * @var ApplicationEquipment $value
             */

            $allSum = 0;
            $allTotalPaid = 0;
            foreach ($app_eq as $value) {
                $allSum += (float)$value->sum;
                $allTotalPaid += (float)$value->total_paid;
            }

            $allSum = $allSum / count($app_eq);
            $arr = $app_eq;
        } else {
            $arr[] = $app_eq;
            $allSum = $app_eq->sum;
            $allTotalPaid = $app_eq->total_paid;
        }

        /**
         * @var ApplicationEquipment $value
         */
        foreach ($arr as $value) {
            $hire_state_id = $value->hire_state_id;

            $date = date('Y-m-d H:i:s');
            $rent_end = $value->application->rent_end;
            $rent_start = $value->application->rent_start;

            $dateDiff = (strtotime($date) - strtotime($rent_end)) / (60 * 60);

            Yii::info('Текущее время: ' . serialize($date), __METHOD__);
            Yii::info('Дата окончания аренды: ' . serialize($rent_end), __METHOD__);

            Yii::info('Разница времени в часах: ' . serialize($dateDiff), __METHOD__);

            $msg = 'Состояние успешно изменено';
            // статус заявки в прокате
            if ($rent_start < $date && $date < $rent_end) {
                $hire_state_id = 4;
            };

            // закрыт - (отстутствии долгов и возвращении оборудования на склад и прошло менее 3 часов)
            if ($allSum <= $allTotalPaid && $dateDiff < 3 && $value->equipments->status === 4) {
                $hire_state_id = 3;
                $msg = 'Прокат успешно закрыт';
            }

            // просрочен - по истечению времени первичного проката прокат не продлен, оборудование не возвращено
            if ($date > $rent_end && $value->equipments->status === 1) {
                $hire_state_id = 2;
                $msg = 'Невозможно закрыть. Оборудование у клиента';
            }

            // долг - прокат не продлен, оборудование возвращено, но есть долг по оплате
            if ($allSum > $allTotalPaid && $value->equipments->status === 4) {
                $hire_state_id = 5;
                $msg = 'Невозможно закрыть. Есть долг';
            }

            $value->hire_state_id = $hire_state_id;

            try {
                if (!$value->save(false)) {
                    Yii::error('Ошибка при закрытии проката: ' . serialize($value->getErrors()), __METHOD__);
                    return false;
                }
            } catch (\Exception $e) {
                Yii::error('Поймали Exception при закрытии проката: ' . serialize($e->getMessage()), __METHOD__);
                return false;
            }

            Yii::info('Заявка успешно изменена', __METHOD__);
        }

        return [
            'status' => 'SUCCESS',
            'msg' => $msg
        ];
    }
}