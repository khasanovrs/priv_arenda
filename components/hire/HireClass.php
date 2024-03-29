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
use app\models\ApplicationSumDelivery;
use app\models\Equipments;
use app\models\Extension;
use app\models\HireField;
use app\models\HireLesaField;
use app\models\HireLesaShowField;
use app\models\HireShowField;
use app\models\HireState;
use app\models\Users;
use Symfony\Component\Console\Application;
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
         * @var HireState $value
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
            $listFilter[] = 'applications.hire_state_id!=3';
        }

        if ($stockUser !== '') {
            $listFilter[] = 'applications.is_not_active=0 and applications.status_id in (1,2) and applications.branch_id=' . $stockUser;
        } else {
            $listFilter[] = 'applications.is_not_active=0 and applications.status_id in (1,2)';
        }

        $listFilter[] = $lesa ? 'applications.lesa=1' : 'applications.lesa=0';

        $list = Applications::find()->joinWith(['applicationEquipments', 'applicationEquipments.equipments', 'applicationEquipments.equipments.mark0', 'applicationEquipments.equipments.type0'])->leftJoin('clients', '`clients`.`id` = `applications`.`client_id`')->where(implode(" and ", $listFilter), $params)->orderBy('id desc')->all();


        if (empty($list)) {
            Yii::info('Список прокатов пуст', __METHOD__);

            return [
                'status' => 'SUCCESS',
                'msg' => 'Список прокатов пуст',
                'data' => $result
            ];
        }

        /**
         * @var Applications $value
         */

        $keyArr = 0;
        foreach ($list as $value) {
            $date_cr = date('Y-m-d');

            if (count($value->applicationEquipments) === 0) {
                Yii::info('Список пуст', __METHOD__);
                continue;
            }

            if (!$lesa) {
                $app_eq = $value->applicationEquipments[0];
                $eq = $app_eq->equipments;
                $mark = $eq->mark0->name;
                $model = $eq->model;
                $type = $eq->type0->name;
            }

            /**
             * @var ApplicationPay $checkPay
             */
            $sumCurrentDay = ApplicationPay::find()->joinWith('cashBox0')->where('finance_cashbox.check_zalog=0 and finance_cashbox.delivery=0 and application_id=:id and date_create like :date', [':id' => $value->id, ':date' => $date_cr . '%'])->sum('application_pay.sum');


            $client = ClientsClass::GetClientInfo($value->client_id);

            $result[$keyArr] = [
                'id' => $value->id,
                'dog_num' => $value->num_dog,
                'typeLease_id' => $value->type_lease_id,
                'client' => $client->name,
                'client_phone' => $client->phone,
                'equipments' => $lesa ? 'Леса' : $type . ' ' . $mark . ' ' . $model,
                'start_hire' => date('d.m.Y H:i:s', strtotime($value->rent_start)),
                'end_hire' => $value->rent_end,
                'status' => $value->hire_state_id,
                'state' => $value->hireState->name,
                //@todo сделать color 'color' => $value->hireState->color,
                'sum' => !$lesa ? $eq->price_per_day : $value->month_sum, // цена оборудования
                'sum_hire' => $value->sum, // сумма аренды со скдикой
                'sale_sum' => $value->sum_sale, // общая сумма со скидкой
                'total_paid' => $value->total_paid, // всего оплачено
                'remainder' => (float)$value->sum - (float)$value->total_paid, // остаток
                'date_create' => date('d.m.Y H:i:s', strtotime($value->date_create)),
                'comment' => $value->comment,
                'date_end' => $value->date_end,
                'branch' => $value->branch->name,
                'delivery_sum' => $value->deliverySum->delivery_sum,
                'delivery_sum_paid' => $value->deliverySum->delivery_sum_paid,
                'current_pay' => (float)$sumCurrentDay,
                'square' => $value->square,
                'rama_prokhodnaya' => 0,
                'rama_letsnitsey' => 0,
                'diagonalnaya_svyaz' => 0,
                'gorizontalnaya_svyaz' => 0,
                'rigel' => 0,
                'nastil' => 0,
            ];

            if ($lesa) {
                $app_eq = $value->applicationEquipments;
                /**
                 * @var ApplicationEquipment $item
                 */
                foreach ($app_eq as $item) {
                    $rama_prokhodnaya = 0;
                    $rama_letsnitsey = 0;
                    $diagonalnaya_svyaz = 0;
                    $gorizontalnaya_svyaz = 0;
                    $rigel = 0;
                    $nastil = 0;

                    Yii::info('Определяем тип', __METHOD__);
                    $type = $item->equipments->type0->name;

                    if ($type == 'Рама проходная') {
                        $rama_prokhodnaya = $item->equipments_count;
                    } elseif ($type == 'Рама с лестницей') {
                        $rama_letsnitsey = $item->equipments_count;
                    } elseif ($type == 'Диагональная связь') {
                        $diagonalnaya_svyaz = $item->equipments_count;
                    } elseif ($type == 'Горизонтальная связь') {
                        $gorizontalnaya_svyaz = $item->equipments_count;
                    } elseif ($type == 'Ригель') {
                        $rigel = $item->equipments_count;
                    } elseif ($type == 'Настил') {
                        $nastil = $item->equipments_count;
                    }

                    $result[$keyArr]['rama_prokhodnaya'] = $rama_prokhodnaya != 0 ? $rama_prokhodnaya : $result[$keyArr]['rama_prokhodnaya'];
                    $result[$keyArr]['rama_letsnitsey'] = $rama_letsnitsey != 0 ? $rama_letsnitsey : $result[$keyArr]['rama_letsnitsey'];
                    $result[$keyArr]['diagonalnaya_svyaz'] = $diagonalnaya_svyaz != 0 ? $diagonalnaya_svyaz : $result[$keyArr]['diagonalnaya_svyaz'];
                    $result[$keyArr]['gorizontalnaya_svyaz'] = $gorizontalnaya_svyaz != 0 ? $gorizontalnaya_svyaz : $result[$keyArr]['gorizontalnaya_svyaz'];
                    $result[$keyArr]['rigel'] = $rigel != 0 ? $rigel : $result[$keyArr]['rigel'];
                    $result[$keyArr]['nastil'] = $nastil != 0 ? $nastil : $result[$keyArr]['nastil'];
                }
            }

            $keyArr++;
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
         * @var Applications $app
         */
        $app = Applications::find()->where('id=:id', [':id' => $id])->one();

        if (!is_object($app)) {
            Yii::info('Ошибка при получении заявки', __METHOD__);

            return [
                'status' => 'SUCCESS',
                'msg' => 'Ошибка при получении заявки'
            ];
        }

        $client = ClientsClass::GetClientInfo($app->client_id);

        if ($app->lesa === '0') {
            $eq = $app->applicationEquipments[0]->equipments;
            $mark = $eq->mark0->name;
            $model = $eq->model;
            $category = $eq->category->name;
            $nameEq = $category . ' ' . $mark . ' ' . $model;
            $photoEq = $eq->photo;
            $photo_aliasEq = $eq->photo_alias;
        } else {
            $nameEq = 'Леса';
            $photoEq = '';
            $photo_aliasEq = '';
        }

        $pay_list = PayClass::getPayList($app->id);

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

        $extensions_list = PayClass::getExtensions($app->id);

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

        Yii::info('Разбор доставки', __METHOD__);

        $delivery_app = [];

        $appArr = Applications::find()->where('delivery_sum_id=:delivery_sum_id', [':delivery_sum_id' => $app->delivery_sum_id])->all();
        if (count($appArr) > 1) {
            /**
             * @var Applications $item
             */
            foreach ($appArr as $item) {
                if ($item->lesa !== '1') {
                    $eq_tmp = $item->applicationEquipments[0]->equipments;
                    $mark_tmp = $eq_tmp->mark0->name;
                    $model_tmp = $eq_tmp->model;
                    $category_tmp = $eq_tmp->category->name;
                    $name = $category_tmp . ' ' . $mark_tmp . ' ' . $model_tmp;
                } else {
                    $name = 'Леса';
                }

                $delivery_app[] = [
                    'id' => $item->id,
                    'name' => $name
                ];
            }
        }

        $deliver_data = [
            'delivery_sum' => $app->deliverySum->delivery_sum,
            'delivery_sum_paid' => $app->deliverySum->delivery_sum_paid,
            'delivery_app' => $delivery_app
        ];


        $result = [
            'id' => $app->id,
            'branch' => $app->branch->name,
            'delivery' => $app->delivery_id,
            'typeLease_id' => $app->type_lease_id,
            'sale' => $app->discount_id,
            'hire_state_id' => $app->hire_state_id,
            'hire_state' => $app->hireState->name,
            'source' => $app->source->name,
            'comment' => $app->comment,
            'rent_start' => $app->rent_start,
            'rent_end' => $app->rent_end,
            'client_fio' => $client->name,
            'client_phone' => $client->phone,
            'sum' => $app->sum,
            'total_paid' => $app->total_paid,
            'remainder' => $app->sum - $app->total_paid,
            'count' => 0,
            'equipments' =>
                [
                    'name' => $nameEq,
                    'state' => $app->equipmentsStatus->name,
                    'state_id' => $app->equipments_status,
                    'photo' => $photoEq,
                    'photo_alias' => $photo_aliasEq
                ],
            'extensions' => $extensions_list['data'],
            'pay_list' => $pay_list['data'],
            'lesa' => $app->lesa,
            'rama_prokhodnaya' => 0,
            'rama_letsnitsey' => 0,
            'diagonalnaya_svyaz' => 0,
            'gorizontalnaya_svyaz' => 0,
            'rigel' => 0,
            'nastil' => 0,
            'month_sum' => $app->month_sum,
            'square' => $app->square,
            'address' => $app->address,
            'delivery_data' => $deliver_data
        ];

        if ($app->lesa === '1') {
            $list = $app->applicationEquipments;

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
     * @param $typeLease_id
     * @return array|bool
     */
    public static function UpdateHire($id, $comment, $delivery, $sale, $rent_start, $rent_end, $typeLease_id)
    {
        if ($id === '') {
            Yii::error('Не передан идентификатор заявки, applicationId: ' . serialize($id), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не передан идентификатор клиента',
            ];
        }

        /**
         * @var Applications $app
         */
        $app = Applications::find()->where('id=:id', [':id' => $id])->one();

        if (!is_object($app)) {
            Yii::info('Ошибка при получении заявки', __METHOD__);

            return [
                'status' => 'SUCCESS',
                'msg' => 'Ошибка при получении заявки'
            ];
        }

        if (!is_object($app)) {
            Yii::error('Ошибка при получении основной заявки', __METHOD__);

            return [
                'status' => 'SUCCESS',
                'msg' => 'Ошибка при получении заявки'
            ];
        }

        if ((int)$app->type_lease_id !== (int)$typeLease_id) {
            Yii::info('Изменили тип доставки', __METHOD__);
        }

        $app->comment = $comment;
        $app->type_lease_id = $typeLease_id;
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
     * @param $app_id
     * @param $count
     * @return array|bool
     * @throws \yii\base\InvalidConfigException
     */
    public static function ExtendRental($app_id, $count)
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

            if ((int)$applications->type_lease_id === 1) {
                $dateDiff = ((strtotime($applications->rent_end) - strtotime($applications->rent_start)) / (60 * 60 * 24));
            } else {
                $dateDiff = floor(((strtotime($applications->rent_end) - strtotime($applications->rent_start)) / (60 * 60 * 24)) / 30);
                $dateDiff *= 30;
            }
            Yii::info('Период аренды в днях: ' . serialize($dateDiff), __METHOD__);

            if ($applications->lesa === '0') {
                $price = round($dateDiff * $equipments->price_per_day * $value->equipments_count);
            } else {
                $price = round($dateDiff * ($applications->month_sum / 30));
            }

            if ((int)$applications->discount->code !== 0) {
                $price = $price - ($price * $applications->discount->code / 100);
            }

            $applications->sum = round($price);
            $applications->hire_state_id = 4;
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

            try {
                if (!$applications->save(false)) {
                    Yii::error('Ошибка при сохранении новой суммы: ' . serialize($applications->getErrors()), __METHOD__);
                    return false;
                }
            } catch (\Exception $e) {
                Yii::error('Поймали Exception при сохранении новой суммы: ' . serialize($e->getMessage()), __METHOD__);
                return false;
            }
        }

        $check = self::checkHire($applications->id);

        if (!is_array($check) || !isset($check['status']) || $check['status'] != 'SUCCESS') {
            Yii::error('Ошибка при продлении контракта', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при изменении состояния',
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

        $extension = new Extension();
        $extension->count = $count;
        $extension->date_create = date('Y-m-d H:i:s');
        $extension->user_id = $session->user_id;
        $extension->type = $applications->type_lease_id;
        $extension->application_id = $applications->id;
        $extension->extend = '1';

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
     * @param $app_id
     * @param $count
     * @return array|bool
     * @throws \yii\base\InvalidConfigException
     */
    public static function TameRental($app_id, $count)
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

            if ($applications->type_lease_id === 1) {
                $dateDiff = ((strtotime($applications->rent_end) - strtotime($applications->rent_start)) / (60 * 60 * 24));
            } else {
                $dateDiff = floor(((strtotime($applications->rent_end) - strtotime($applications->rent_start)) / (60 * 60 * 24)) / 30);
                $dateDiff *= 30;
            }
            Yii::info('Период аренды в днях: ' . serialize($dateDiff), __METHOD__);


            if ($applications->lesa === '0') {
                $price = round($dateDiff * $equipments->price_per_day * $value->equipments_count);
            } else {
                $price = round($dateDiff * ($applications->month_sum / 30));
            }

            if ((int)$applications->discount->code !== 0) {
                $price = $price - ($price * $applications->discount->code / 100);
            }

            $applications->sum = round($price);

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

            try {
                if (!$applications->save(false)) {
                    Yii::error('Ошибка при сохранении новой суммы: ' . serialize($applications->getErrors()), __METHOD__);
                    return false;
                }
            } catch (\Exception $e) {
                Yii::error('Поймали Exception при сохранении новой суммы: ' . serialize($e->getMessage()), __METHOD__);
                return false;
            }
        }

        $check = self::checkHire($applications->id);
        if (!is_array($check) || !isset($check['status']) || $check['status'] != 'SUCCESS') {
            Yii::error('Ошибка при продлении контракта', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при изменении состояния',
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

        $extension = new Extension();
        $extension->count = $count;
        $extension->date_create = date('Y-m-d H:i:s');
        $extension->user_id = $session->user_id;
        $extension->type = $applications->type_lease_id;
        $extension->application_id = $applications->id;
        $extension->extend = '0';

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
     * @throws \yii\base\InvalidConfigException
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
         * @var Applications $app
         */
        $app = Applications::find()->where('id=:id', [':id' => $app_id])->one();

        if (!is_object($app)) {
            Yii::info('Информация об оборудовании по заявке не найдена', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Заявка не найдена'
            ];
        }

        $app_eq = $app->applicationEquipments;

        if (empty($app_eq)) {
            Yii::info('Информация об оборудовании по заявке не найдена', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Заявка не найдена'
            ];
        }

        /**
         * @var ApplicationEquipment $item
         */
        foreach ($app_eq as $item) {
            $status = 4;

            if ($app->lesa === '1') {
                $eq = $item->equipments;
                $eq->count_hire -= $item->equipments_count;

                try {
                    if (!$eq->save(false)) {
                        Yii::error('Ошибка при сохранении количества проката: ' . serialize($eq->getErrors()), __METHOD__);
                        return false;
                    }
                } catch (\Exception $e) {
                    Yii::error('Поймали Exception при закрытии проката: ' . serialize($e->getMessage()), __METHOD__);
                    return false;
                }

                $status = $eq->count === $eq->count_hire > 0 ? 4 : 1;
            }

            $checkChangeStatus = EquipmentsClass::changeStatus($item->equipments_id, $status);

            if (!is_array($checkChangeStatus) || !isset($checkChangeStatus['status']) || $checkChangeStatus['status'] != 'SUCCESS') {
                Yii::error('Ошибка при изменении статуса', __METHOD__);

                return [
                    'status' => 'ERROR',
                    'msg' => 'Ошибка при изменении статуса',
                ];
            }
        }

        $hire_state_id = '';

        // долг - прокат не продлен, оборудование возвращено, но есть долг по оплате
        if ($app->sum > $app->total_paid) {
            $hire_state_id = 5;
        }

        if ($hire_state_id !== '') {
            $app->hire_state_id = $hire_state_id;
        }

        $app->equipments_status = 4;

        try {
            if (!$app->save(false)) {
                Yii::error('Ошибка при закрытии проката: ' . serialize($app->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при закрытии проката: ' . serialize($e->getMessage()), __METHOD__);
            return false;
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

        $check = self::checkHire($app_id, true);

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
     * @param $app_id
     * @param $check_close
     * @return array|bool
     */
    public static function checkHire($app_id, $check_close = false)
    {
        Yii::info('Проверка и изменение состояния проката', __METHOD__);

        /**
         * @var Applications $app
         */
        $app = Applications::find()->where('id=:id', [':id' => $app_id])->one();

        if (!is_object($app)) {
            Yii::info('Информация о заявке не найдена', __METHOD__);

            return ['status' => 'ERROR',
                'msg' => 'Заявка не найдена'];
        }

        $hire_state_id = $app->hire_state_id;

        $date = date('Y-m-d H:i:s');
        $rent_end = $app->rent_end;
        $rent_start = $app->rent_start;

        $dateDiff = (strtotime($date) - strtotime($rent_end)) / (60 * 60);

        $delivery_sum = $app->deliverySum->delivery_sum;
        $delivery_sum_paid = $app->deliverySum->delivery_sum_paid;

        Yii::info('Текущее время: ' . serialize($date), __METHOD__);
        Yii::info('Дата окончания аренды: ' . serialize($rent_end), __METHOD__);
        Yii::info('Разница времени в часах: ' . serialize($dateDiff), __METHOD__);

// статус заявки в прокате
        if ($rent_start < $date && $date < $rent_end) {
            $hire_state_id = 4;
        };

        $msg = 'Состояние успешно изменено';

// закрыт - (отстутствии долгов и возвращении оборудования на склад и прошло менее 3 часов)
        if ((($delivery_sum <= $delivery_sum_paid || $app->sum <= $app->total_paid) && $dateDiff < 3 && $app->equipments_status === 4) && $check_close) {
            $check = ApplicationPay::find()
                ->joinWith('cashBox0')
                ->where('application_id=:application_id and finance_cashbox.check_zalog=1', [':application_id' => $app->id])
                ->sum('application_pay.sum');


            Yii::info('Проверяем сумму в залоге' . serialize($check), __METHOD__);
            if ($check !== null && (int)$check > 0) {
                return [
                    'status' => 'SUCCESS',
                    'msg' => 'Невозможно закрыть. В залоге сумма: ' . $check
                ];
            }

            $hire_state_id = 3;
            $msg = 'Прокат успешно закрыт';
        }

        // оборудование не возвращено
        if ($app->equipments_status === 1) {
            $msg = 'Невозможно закрыть, оборудование в аренде';
        }

        // просрочен - по истечению времени первичного проката прокат не продлен, оборудование не возвращено
        if ($date > $rent_end && $app->equipments_status === 1) {
            $hire_state_id = 2;
            $msg = 'Невозможно закрыть. Оборудование у клиента';
        }

        // долг - прокат не продлен, оборудование возвращено, но есть долг по оплате
        if (($delivery_sum > $delivery_sum_paid || $app->sum > $app->total_paid) && $app->equipments_status === 4) {
            $hire_state_id = 5;
            $msg = 'Невозможно закрыть. Есть долг';
        }

        $app->hire_state_id = $hire_state_id;

        try {
            if (!$app->save(false)) {
                Yii::error('Ошибка при изменении состояния проката: ' . serialize($app->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при закрытии проката: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        Yii::info('Заявка успешно изменена', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => $msg
        ];
    }
}