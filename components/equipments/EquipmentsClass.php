<?php
/**
 * Управление оборудованием
 */

namespace app\components\equipments;

use app\components\finance\FinanceClass;
use app\components\pay\PayClass;
use app\components\Session\Sessions;
use app\models\ApplicationEquipment;
use app\models\ApplicationsDemand;
use app\models\Equipments;
use app\models\EquipmentsCategory;
use app\models\EquipmentsDemand;
use app\models\EquipmentsDemandField;
use app\models\EquipmentsField;
use app\models\EquipmentsHistory;
use app\models\EquipmentsHistoryChangeStatus;
use app\models\EquipmentsInfo;
use app\models\EquipmentsMark;
use app\models\EquipmentsShowField;
use app\models\EquipmentsStatus;
use app\models\EquipmentsType;
use app\models\FinanceCashbox;
use app\models\Stock;
use app\models\Users;
use Yii;

class EquipmentsClass
{
    /**
     * Получение типов оборудования
     * @return bool|array
     */
    public static function GetEquipmentsType()
    {
        Yii::info('Запуск функции GetDiscount', __METHOD__);
        $result = [];

        $equipmentsTypeList = EquipmentsType::find()->orderBy('id')->all();

        if (!is_array($equipmentsTypeList)) {
            Yii::error('Список типов оборудования пуст', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Список типов оборудования пуст'
            ];
        }

        /**
         * @var EquipmentsType $value
         */
        foreach ($equipmentsTypeList as $value) {
            $result[] = [
                'val' => $value->id,
                'name' => $value->name,
                'category_id' => $value->category_id,
            ];
        }

        Yii::info('Список типов оборудования получен', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Список типов оборудования получен',
            'data' => $result
        ];
    }

    /**
     * Получение категорий оборудования
     * @return bool|array
     */
    public static function GetEquipmentsCategory()
    {
        Yii::info('Запуск функции GetEquipmentsCategory', __METHOD__);
        $result = [];

        $equipmentsTypeList = EquipmentsCategory::find()->orderBy('id')->all();

        if (!is_array($equipmentsTypeList)) {
            Yii::error('Список категорий оборудования пуст', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Список категорий оборудования пуст'
            ];
        }

        /**
         * @var EquipmentsCategory $value
         */
        foreach ($equipmentsTypeList as $value) {

            $type_arr = $value->equipmentsTypes;
            $type_list = [];

            if (!empty($type_arr)) {
                /**
                 * @var EquipmentsType $value
                 */
                foreach ($type_arr as $value2) {
                    $type_list[] = [
                        'val' => $value2->id,
                        'name' => $value2->name
                    ];
                }
            }

            $result[] = [
                'val' => $value->id,
                'name' => $value->name,
                'type' => $type_list
            ];
        }

        Yii::info('Список категорий оборудования получен', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Список категорий оборудования получен',
            'data' => $result
        ];
    }

    /**
     * Получение статусов оборудования
     * @return bool|array
     */
    public static function GetEquipmentsStatus()
    {
        Yii::info('Запуск функции GetEquipmentsAvailability', __METHOD__);
        $result = [];

        $equipmentsAvailabilityList = EquipmentsStatus::find()->orderBy('id')->all();

        if (!is_array($equipmentsAvailabilityList)) {
            Yii::error('Список статусов оборудования пуст', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Список статусов оборудований пуст'
            ];
        }

        /**
         * @var EquipmentsStatus $value
         */
        foreach ($equipmentsAvailabilityList as $value) {
            $result[] = [
                'val' => $value->id,
                'name' => $value->name,
                'color' => $value->color
            ];
        }

        Yii::info('Список статусов оборудования получен', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Список статусов оборудования получен',
            'data' => $result
        ];
    }

    /**
     * Получение списка оборудования
     * @param $status
     * @param $like
     * @param $stock
     * @param $equipmentsType
     * @param $equipmentsCategory
     * @param $count_start
     * @param $count_end
     * @param $selling_price_start
     * @param $selling_price_end
     * @param $price_per_day_start
     * @param $price_per_day_end
     * @param $rentals_start
     * @param $rentals_end
     * @param $repairs_start
     * @param $repairs_end
     * @param $repairs_sum_start
     * @param $repairs_sum_end
     * @param $revenue_start
     * @param $revenue_end
     * @param $profit_start
     * @param $profit_end
     * @param $degree_wear_start
     * @param $degree_wear_end
     * @param $lesa
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public static function GetEquipments($status, $like, $stock, $equipmentsType, $equipmentsCategory, $count_start, $count_end, $selling_price_start, $selling_price_end, $price_per_day_start, $price_per_day_end, $rentals_start, $rentals_end, $repairs_start, $repairs_end, $repairs_sum_start, $repairs_sum_end, $revenue_start, $revenue_end, $profit_start, $profit_end, $degree_wear_start, $degree_wear_end, $lesa)
    {
        Yii::info('Запуск функции GetEquipments' . serialize($like), __METHOD__);

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
            $stockUserObject = $user->branch->stocks[0];

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

            if ($status === '4') {
                $listFilter[] = 'status not in (2,3)';
            } elseif ($status === '5') {
                $listFilter[] = 'status in (1,2,4)';
            } else {
                $listFilter[] = 'status=' . $status;
            }
        }

        if ($stock !== '' and $stock !== null) {
            Yii::info('Параметр stock: ' . serialize($stock), __METHOD__);
            $listFilter[] = 'stock_id=:stock';
            $params[':stock'] = $stock;
        }

        if ($equipmentsType !== '' and $equipmentsType !== null) {
            Yii::info('Параметр equipmentsType: ' . serialize($equipmentsType), __METHOD__);
            $listFilter[] = 'type=:equipmentsType';
            $params[':equipmentsType'] = $equipmentsType;
        }

        if ($equipmentsCategory !== '' and $equipmentsCategory !== null) {
            Yii::info('Параметр equipmentsCategory: ' . serialize($equipmentsCategory), __METHOD__);
            $listFilter[] = 'equipments.category_id=:equipmentsCategory';
            $params[':equipmentsCategory'] = $equipmentsCategory;
        }

        if ($count_start !== '' and $count_start !== null) {
            Yii::info('Параметр count_start: ' . serialize($count_start), __METHOD__);
            $listFilter[] = 'count>:count_start';
            $params[':count_start'] = $count_start;
        }

        if ($count_end !== '' and $count_end !== null) {
            Yii::info('Параметр count_end: ' . serialize($count_end), __METHOD__);
            $listFilter[] = 'count<:count_end';
            $params[':count_end'] = $count_end;
        }

        if ($selling_price_start !== '' and $selling_price_start !== null) {
            Yii::info('Параметр selling_price_start: ' . serialize($selling_price_start), __METHOD__);
            $listFilter[] = 'selling_price>:selling_price_start';
            $params[':selling_price_start'] = $selling_price_start;
        }

        if ($selling_price_end !== '' and $selling_price_end !== null) {
            Yii::info('Параметр selling_price_end: ' . serialize($selling_price_end), __METHOD__);
            $listFilter[] = 'selling_price<:selling_price_end';
            $params[':selling_price_end'] = $selling_price_end;
        }

        if ($price_per_day_start !== '' and $price_per_day_start !== null) {
            Yii::info('Параметр price_per_day_start: ' . serialize($price_per_day_start), __METHOD__);
            $listFilter[] = 'price_per_day>:price_per_day_start';
            $params[':price_per_day_start'] = $price_per_day_start;
        }

        if ($price_per_day_end !== '' and $price_per_day_end !== null) {
            Yii::info('Параметр price_per_day_end: ' . serialize($price_per_day_end), __METHOD__);
            $listFilter[] = 'price_per_day<:price_per_day_end';
            $params[':price_per_day_end'] = $price_per_day_end;
        }

        if ($rentals_start !== '' and $rentals_start !== null) {
            Yii::info('Параметр rentals_start: ' . serialize($rentals_start), __METHOD__);
            $listFilter[] = 'rentals>:rentals_start';
            $params[':rentals_start'] = $rentals_start;
        }

        if ($rentals_end !== '' and $rentals_end !== null) {
            Yii::info('Параметр rentals_end: ' . serialize($rentals_end), __METHOD__);
            $listFilter[] = 'rentals<:rentals_end';
            $params[':rentals_end'] = $rentals_end;
        }

        if ($repairs_start !== '' and $repairs_start !== null) {
            Yii::info('Параметр repairs_start: ' . serialize($repairs_start), __METHOD__);
            $listFilter[] = 'repairs>:repairs_start';
            $params[':repairs_start'] = $repairs_start;
        }

        if ($repairs_end !== '' and $repairs_end !== null) {
            Yii::info('Параметр repairs_end: ' . serialize($repairs_end), __METHOD__);
            $listFilter[] = 'repairs<:repairs_end';
            $params[':repairs_end'] = $repairs_end;
        }

        if ($repairs_sum_start !== '' and $repairs_sum_start !== null) {
            Yii::info('Параметр repairs_sum_start: ' . serialize($repairs_sum_start), __METHOD__);
            $listFilter[] = 'repairs_sum>:repairs_sum_start';
            $params[':repairs_sum_start'] = $repairs_sum_start;
        }

        if ($repairs_sum_end !== '' and $repairs_sum_end !== null) {
            Yii::info('Параметр repairs_sum_end: ' . serialize($repairs_sum_end), __METHOD__);
            $listFilter[] = 'repairs_sum<:repairs_sum_end';
            $params[':repairs_sum_end'] = $repairs_sum_end;
        }

        if ($revenue_start !== '' and $revenue_start !== null) {
            Yii::info('Параметр revenue_start: ' . serialize($revenue_start), __METHOD__);
            $listFilter[] = 'revenue>:revenue_start';
            $params[':revenue_start'] = $revenue_start;
        }

        if ($revenue_end !== '' and $revenue_end !== null) {
            Yii::info('Параметр revenue_end: ' . serialize($revenue_end), __METHOD__);
            $listFilter[] = 'revenue<:revenue_end';
            $params[':revenue_end'] = $revenue_end;
        }

        if ($profit_start !== '' and $profit_start !== null) {
            Yii::info('Параметр profit_start: ' . serialize($profit_start), __METHOD__);
            $listFilter[] = 'profit>:profit_start';
            $params[':profit_start'] = $profit_start;
        }

        if ($profit_end !== '' and $profit_end !== null) {
            Yii::info('Параметр profit_end: ' . serialize($profit_end), __METHOD__);
            $listFilter[] = 'profit<:profit_end';
            $params[':profit_end'] = $profit_end;
        }

        if ($degree_wear_start !== '' and $degree_wear_start !== null) {
            Yii::info('Параметр degree_wear_start: ' . serialize($degree_wear_start), __METHOD__);
            $listFilter[] = 'degree_wear>:degree_wear_start';
            $params[':degree_wear_start'] = $degree_wear_start;
        }

        if ($degree_wear_end !== '' and $degree_wear_end !== null) {
            Yii::info('Параметр degree_wear_end: ' . serialize($degree_wear_end), __METHOD__);
            $listFilter[] = 'degree_wear<:degree_wear_end';
            $params[':degree_wear_end'] = $degree_wear_end;
        }

        if ($like !== '' and $like !== null) {
            Yii::info('Параметр like: ' . serialize($like), __METHOD__);
            $like = mb_strtolower($like);
            $like = '%' . $like . '%';
            $listFilter[] = 'lower(model) like :like or lower(equipments_mark.name) like :like or lower(equipments_type.name) like :like or lower(equipments_category.name) like :like';
            $params[':like'] = strtolower($like);
        }

        // леса
        $listFilter[] = $lesa ? 'equipments.category_id=33' : 'equipments.category_id!=33';

        // определяем менеджера
        if ($stockUser !== '') {
            $listFilter[] = 'stock_id=' . $stockUser;
        }

        // только активные
        $listFilter[] = 'is_not_active=0';

        $equipmentsTypeList = Equipments::find()->joinWith(['mark0', 'status0', 'stock', 'type0', 'category', 'equipmentsInfos'])->where(implode(" and ", $listFilter), $params)->orderBy('id desc')->all();

        if (!is_array($equipmentsTypeList)) {
            Yii::error('Список категорий оборудования пуст', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Список категорий оборудования пуст'
            ];
        }

        /**
         * @var Equipments $value
         */
        foreach ($equipmentsTypeList as $value) {
            $result[] = [
                'id' => $value->id,
                'name' => $value->type0->name . ' ' . $value->mark0->name . ' ' . $value->model,
                'category' => $value->category->name,
                'stock' => $value->stock->name,
                'type' => $value->type0->name,
                'status' => $value->status0->name,
                'dop_status' => $value->dop_status,
                'color' => $value->status0->color,
                'selling_price' => +$value->selling_price,
                'price_per_day' => +$value->price_per_day,
                'rentals' => $value->rentals,
                'repairs' => $value->repairs,
                'repairs_sum' => $value->repairs_sum,
                'tool_number' => $value->tool_number,
                'revenue' => $value->revenue,
                'profit' => $value->profit,
                'degree_wear' => $value->degree_wear,
                'payback_ratio' => $value->payback_ratio,
                'date_create' => $value->date_create,
                'comment' => $value->equipmentsInfos[0]->comment,
                'count' => +$value->count,
                'count_hire' => +$value->count_hire,
                'count_left' => +$value->count - +$value->count_hire
            ];
        }

        Yii::info('Список оборудования получен', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Список оборудования получен',
            'data' => $result
        ];
    }

    /**
     * Получение списка оборудования
     * @param $like
     * @param $stock
     * @param $type
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public static function GetEquipmentsDemand($like, $stock, $type)
    {
        Yii::info('Запуск функции GetEquipmentsDemand' . serialize($like), __METHOD__);

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
            $stockUserObject = $user->branch->stocks[0];

            if (!is_object($stockUserObject)) {
                Yii::error('Ошибка при определении филиала у менеджера' . serialize($stockUser), __METHOD__);

                return [
                    'status' => 'ERROR',
                    'msg' => 'Ошибка при определении филиала у менеджера',
                ];
            }

            $stockUser = $stockUserObject->id;
        }

        // определяем менеджера
        if ($stockUser !== '') {
            $listFilter[] = 'stock_id=' . $stockUser;
        }

        if ($type === 'eq') {
            if ($like !== '' and $like !== null) {
                Yii::info('Параметр like: ' . serialize($like), __METHOD__);
                $like = mb_strtolower($like);
                $like = '%' . $like . '%';
                $listFilter[] = 'lower(model) like :like';
                $params[':like'] = strtolower($like);
            }

            $equipmentsTypeList = EquipmentsDemand::find()->where(implode(" and ", $listFilter), $params)->orderBy('id desc')->all();

            if (!is_array($equipmentsTypeList)) {
                Yii::error('Список категорий оборудования пуст', __METHOD__);

                return [
                    'status' => 'ERROR',
                    'msg' => 'Список категорий оборудования пуст'
                ];
            }

            /**
             * @var EquipmentsDemand $value
             */
            foreach ($equipmentsTypeList as $value) {
                $result[] = [
                    'id' => $value->id,
                    'name' => $value->model,
                    'count_demand' => $value->count_demand,
                ];
            }
        } elseif ($type === 'hire') {
            if ($stock !== '' and $stock !== null) {

                /**
                 * @var Stock $stock
                 */
                $stock = Stock::find()->where('id=:id', [':id' => $stock])->one();
                if (!is_object($stock)) {
                    Yii::error('Филиал не найден', __METHOD__);

                    return [
                        'status' => 'ERROR',
                        'msg' => 'Филиал не найден',
                    ];
                }
            }

            if ($stock !== '' and $stock !== null) {
                Yii::info('Параметр stock: ' . serialize($stock), __METHOD__);
                $listFilter[] = 'branch_id=:stock';
                $params[':stock'] = $stock->id_branch;
            }

            if ($like !== '' and $like !== null) {
                Yii::info('Параметр like: ' . serialize($like), __METHOD__);
                $like = mb_strtolower($like);
                $like = '%' . $like . '%';
                $listFilter[] = 'lower(equipments_demand.model) like :like';
                $params[':like'] = strtolower($like);
            }

            $equipmentsTypeList = ApplicationsDemand::find()->joinWith('eq')->where(implode(" and ", $listFilter), $params)->orderBy('id desc')->all();

            if (!is_array($equipmentsTypeList)) {
                Yii::error('Список категорий оборудования пуст', __METHOD__);

                return [
                    'status' => 'ERROR',
                    'msg' => 'Список категорий оборудования пуст'
                ];
            }

            /**
             * @var ApplicationsDemand $value
             */
            foreach ($equipmentsTypeList as $value) {
                $eq = $value->eq;
                $result[] = [
                    'id' => $value->id,
                    'name' => $eq->model,
                    'stock' => $value->branch->name,
                    'user' => $value->user->fio,
                    'client' => $value->client->name,
                    'coment' => $value->comment,
                    'date_create' => date('d.m.Y', strtotime($value->date_create))
                ];
            }
        }

        Yii::info('Список оборудования получен', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Список оборудования получен',
            'data' => $result
        ];
    }

    /**
     * Получение списка оборудования
     * @param $branch
     * @param $date_start ,
     * @param $date_end
     * @return array
     */
    public static function GetEquipmentsBranch($branch, $date_start, $date_end)
    {
        Yii::info('Запуск функции GetEquipments', __METHOD__);

        $date_start .= ' 00:00:00';
        $date_end .= ' 23:59:59';
        $result = [];

        $applicationEquipment = ApplicationEquipment::find()
            ->select('equipments_id,count(*) as hire_date')
            ->joinWith('application')
            ->where('applications.branch_id=:branch and applications.date_create between :date_start and :date_end', [':branch' => $branch, ':date_start' => $date_start, ':date_end' => $date_end])
            ->groupBy('equipments_id')
            ->orderBy('COUNT(*) desc')
            ->limit(10)
            ->all();

        if (!is_array($applicationEquipment)) {
            Yii::error('Список оборудований пуст', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Список оборудований пуст'
            ];
        }


        foreach ($applicationEquipment as $value) {
            /**
             * @var Equipments $eq
             */
            $eq = Equipments::find()->where('id=:id', [':id' => $value->equipments_id])->one();

            if (!is_object($eq)) {
                Yii::error('Оборудование не найдено', __METHOD__);

                return [
                    'status' => 'ERROR',
                    'msg' => 'Оборудование не найдено'
                ];
            }

            $result[] = [
                'id' => $value->equipments_id,
                'count' => $value->hire_date,
                'name' => $eq->category->name . ' ' . $eq->mark0->name . ' ' . $eq->model,
                'price' => $eq->price_per_day,
                'photo' => $eq->photo,
                'photo_alias' => $eq->photo_alias
            ];
        }

        Yii::info('Список оборудования получен', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Список оборудования получен',
            'data' => $result
        ];
    }

    /**
     * Получение списка оборудования по поиску
     * @param $branch
     * @param $filter
     * @param $applicationStatus
     * @param $lesa
     * @return array
     */
    public static function GetAllEquipmentsBranch($filter, $branch, $applicationStatus, $lesa)
    {
        Yii::info('Запуск функции GetEquipmentsSearch', __METHOD__);
        $result = [];

        if ($branch === '') {
            Yii::error('Филиал не передан', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Филиал не передан'
            ];
        }

        $stock = Stock::find()->where('id_branch = :branch', [':branch' => $branch])->all();

        if (empty($stock)) {
            return [
                'status' => 'SUCCESS',
                'msg' => 'Склады в данном филиале не найдены',
                'data' => []
            ];
        }

        $arr = [];

        /**
         * @var Stock $value
         */

        foreach ($stock as $value) {
            array_push($arr, $value->id);
        }

        // показываем или нет оборудование со спросом
        $secondFilter = $lesa ? ' and equipments.category_id=33' : ' and equipments.category_id!=33';

        $filter = strtolower($filter);
        $filter = '%' . $filter . '%';

        Yii::info('Определяем статус у нового проката, статус:' . serialize($applicationStatus), __METHOD__);

        if ($applicationStatus !== 3) {
            $equipments = Equipments::find()->joinWith(['mark0', 'type0'])->
            where(['in', 'stock_id', $arr])->
            andWhere('(lower(model) like :filter or lower(equipments_mark.name) like :filter or lower(equipments_type.name) like :filter) and status not in (2,3,6)' . $secondFilter, [':filter' => $filter])->
            orderBy('equipments.id desc')->
            limit(20)
                ->all();

            if (empty($equipments)) {
                Yii::error('Список оборудования пуст', __METHOD__);

                return [
                    'status' => 'SUCCESS',
                    'msg' => 'Список оборудования пуст',
                    'data' => $result
                ];
            }

            /**
             * @var Equipments $value
             */
            foreach ($equipments as $value) {
                if ($value->status === 1 || $value->status === 5) {

                    /**
                     * @var ApplicationEquipment $ap_eq
                     */
                    $ap_eq = ApplicationEquipment::find()->joinWith(['application'])->where('equipments_id=:id and applications.branch_id=:branch_id', [':id' => $value->id, ':branch_id' => $branch])->one();

                    if (!is_object($ap_eq)) {
                        Yii::error('Оборудования в данном филиале нет', __METHOD__);

                        continue;
                    }

                    $rent_end = date('d.m.Y H:i', strtotime($ap_eq->application->rent_end));
                    $rent_start = date('d.m.Y H:i', strtotime($ap_eq->application->rent_start));

                    $status = $value->status0->name . ' с ' . $rent_start . ' до ' . $rent_end;
                    $checkClick = '0';
                } else {
                    $status = $value->status0->name;
                    $checkClick = '1';
                }

                if ($lesa && $value->count - $value->count_hire > 0) {
                    $status = 'Доступен';
                    $checkClick = '1';
                }

                $result[] = [
                    'id' => $value->id,
                    'name' => $value->type0->name . ' ' . $value->mark0->name . ' ' . $value->model,
                    'price_per_day' => $value->price_per_day,
                    'status' => $status,
                    'check_click' => $checkClick,
                    'count' => $value->count - $value->count_hire,

                    //'count' => $value->count,
                    //'photo' => $value->photo
                ];
            }
        } else {
            $equipments = EquipmentsDemand::find()->
            where('lower(model) like :filter', [':filter' => $filter])->
            orderBy('id desc')
                ->limit(20)
                ->all();

            if (empty($equipments)) {
                Yii::error('Список оборудования пуст', __METHOD__);

                return [
                    'status' => 'SUCCESS',
                    'msg' => 'Список оборудования пуст',
                    'data' => $result
                ];
            }

            /**
             * @var EquipmentsDemand $value
             */
            foreach ($equipments as $value) {

                $result[] = [
                    'id' => $value->id,
                    'name' => $value->model,
                    'status' => 'Спрос',
                ];
            }
        }

        Yii::info('Список оборудования получен', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Список оборудования получен',
            'data' => $result
        ];
    }

    /**
     * Получение детальной информации об оборудовании
     * @param $equipmentId
     * @return array
     */
    public static function GetEquipmentInfo($equipmentId)
    {
        Yii::info('Запуск функции GetEquipmentInfo', __METHOD__);

        /**
         * @var Equipments $equipment
         */
        $equipment = Equipments::find()->where('id=:id', [':id' => $equipmentId])->one();

        if (!is_object($equipment)) {
            Yii::error('Оборудование не найдено, id:' . serialize($equipmentId), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Оборудование не найдено'
            ];
        }

        $change_history = [];
        $change_history_status = [];

        $change_history_arr = $equipment->equipmentsHistories;

        if (!empty($change_history_arr)) {
            foreach ($change_history_arr as $value) {
                $change_history[] = [
                    'date' => date('d.m.Y H:i:s', strtotime($value->date_create)),
                    'new_params' => $value->new_params,
                    'old_params' => $value->old_params,
                    'type' => $value->typeChange->name,
                    'reason' => $value->reason,
                    'user' => $value->user->fio
                ];
            }
        }

        $change_history_status_arr = $equipment->equipmentsHistoryChangeStatuses;

        if (!empty($change_history_status_arr)) {
            foreach ($change_history_status_arr as $value) {

                /**
                 * @var FinanceCashbox $cashBox
                 */
                $cashBox = FinanceCashbox::find()->where('id=:id', [':id' => $value->cashBox_id])->one();
                $cashBox_name = is_object($cashBox) ? $cashBox->name : '';

                $change_history_status[] = [
                    'date' => date('d.m.Y H:i:s', strtotime($value->date_create)),
                    'new_params' => $value->newStatus->name,
                    'old_params' => $value->oldStatus->name,
                    'cashBox' => $cashBox_name,
                    'sum' => $value->sum,
                    'reason' => $value->reason,
                    'user' => $value->user->fio
                ];
            }
        }

        $result = [
            'id' => $equipment->id,
            'mark' => $equipment->mark,
            'model' => $equipment->model,
            'category' => $equipment->category_id,
            'new_stock' => $equipment->stock_id,
            'old_stock' => $equipment->stock_id,
            'type' => $equipment->type,
            'discount' => $equipment->discount,
            'new_status' => $equipment->status,
            'old_status' => $equipment->status,
            'selling' => $equipment->selling,
            'selling_price' => $equipment->selling_price,
            'price_per_day' => $equipment->price_per_day,
            'rentals' => $equipment->rentals,
            'repairs' => $equipment->repairs,
            'repairs_sum' => $equipment->repairs_sum,
            'tool_number' => $equipment->tool_number,
            'revenue' => $equipment->revenue,
            'profit' => $equipment->profit,
            'photo' => $equipment->photo,
            'photo_alias' => $equipment->photo_alias,
            'degree_wear' => $equipment->degree_wear,
            'payback_ratio' => $equipment->payback_ratio,
            'power_energy' => $equipment->equipmentsInfos[0]->power_energy,
            'length' => $equipment->equipmentsInfos[0]->length,
            'network_cord' => $equipment->equipmentsInfos[0]->network_cord,
            'power' => $equipment->equipmentsInfos[0]->power,
            'frequency_hits' => $equipment->equipmentsInfos[0]->frequency_hits,
            'comment' => $equipment->equipmentsInfos[0]->comment,
            'change_history' => $change_history,
            'change_history_status' => $change_history_status,
            'count' => +$equipment->count,
            'count_hire' => +$equipment->count_hire,
            'count_left' => +$equipment->count - +$equipment->count_hire,
        ];

        Yii::info('Информация об оборудовании получено', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Информация об оборудовании получено',
            'data' => $result
        ];
    }

    /**
     * Получение списка полей для оборудования
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public static function GetEquipmentFields()
    {
        Yii::info('Запуск функции GetEquipmentFields', __METHOD__);
        $result = [];

        $equipmentsFieldList = EquipmentsField::find()->orderBy('id')->all();

        if (!is_array($equipmentsFieldList)) {
            Yii::error('Список полей пуст', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Список категорий оборудования пуст'
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
         * @var EquipmentsField $value
         */
        foreach ($equipmentsFieldList as $value) {
            $check_flag = EquipmentsShowField::find()->where('equipments_field_id=:equipments_field_id and user_id=:user_id', [':equipments_field_id' => $value->id, ':user_id' => $session->user_id])->orderBy('id')->one();

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
     * Получение списка полей для оборудования
     * @return array
     */
    public static function GetEquipmentDemandFields()
    {
        Yii::info('Запуск функции GetEquipmentDemandFields', __METHOD__);
        $result = [];

        $equipmentsFieldList = EquipmentsDemandField::find()->orderBy('id')->all();

        if (!is_array($equipmentsFieldList)) {
            Yii::error('Список полей пуст', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Список категорий оборудования пуст'
            ];
        }


        /**
         * @var EquipmentsField $value
         */
        foreach ($equipmentsFieldList as $value) {
            $result[] = [
                'id' => $value->id,
                'code' => $value->code,
                'name' => $value->name,
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
    public static function ChangeEquipmentFields($params)
    {
        Yii::info('Запуск функции ChangeEquipmentFields', __METHOD__);

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
            EquipmentsShowField::deleteAll('user_id=:user_id', [':user_id' => $session->user_id]);
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при очистке списка скрытых полей : ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        foreach ($params as $value) {
            if ($value->flag === 0) {

                $newVal = new EquipmentsShowField();
                $newVal->user_id = $session->user_id;
                $newVal->equipments_field_id = $value->id;

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
     * Изменение статуса оборудования
     * @param $id
     * @param $status
     * @return bool|array
     */
    public static function ChangeEquipmentsStatus($id, $status)
    {
        Yii::info('Запуск функции ChangeEquipmentsStatus', __METHOD__);

        if ($id === '' || !is_int($status)) {
            Yii::error('Не передан идентификтор организации, id: ' . serialize($id), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не передан идентификтор оборудования',
            ];
        }

        if ($status === '' || !is_int($status)) {
            Yii::error('Передан некорректный статус, status: ' . serialize($status), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Передан некорректный статус',
            ];
        }

        $check_status = EquipmentsStatus::find()->where('id=:id', [':id' => $status])->one();

        if (!is_object($check_status)) {
            Yii::error('Передан некорректный статус, status:' . serialize($status), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Передан некорректный статус',
            ];
        }

        /**
         * @var Equipments $equipments
         */
        $equipments = Equipments::find()->where('id=:id', [':id' => $id])->one();

        if (!is_object($equipments)) {
            Yii::error('По данному идентификатору оборудование не найдено, id' . serialize($id), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Оборудование не найдено',
            ];
        }

        $equipments->status = $status;

        try {
            if (!$equipments->save(false)) {
                Yii::error('Ошибка при обновлении статуса оборудования: ' . serialize($equipments->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при обновлении статуса оборудования: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        Yii::info('Статус оборудования успешно изменен', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Статус оборудования успешно изменен'
        ];
    }

    /**
     * Функция добавления оборудования
     * @param $model
     * @param $mark
     * @param $status
     * @param $stock
     * @param $equipmentsType
     * @param $equipmentsCategory
     * @param $tool_number
     * @param $selling
     * @param $selling_price
     * @param $price_per_day
     * @param $revenue
     * @param $degree_wear
     * @param $discount
     * @param $rentals
     * @param $repairs
     * @param $repairs_sum
     * @param $profit
     * @param $payback_ratio
     * @param $power_energy
     * @param $length
     * @param $network_cord
     * @param $power
     * @param $frequency_hits
     * @param $photo
     * @param $photo_alias
     * @param $comment
     * @param $count
     * @return array|bool
     */
    public static function AddEquipment($model, $mark, $status, $stock, $equipmentsType, $equipmentsCategory, $tool_number, $selling, $selling_price, $price_per_day, $revenue, $degree_wear, $discount, $rentals, $repairs, $repairs_sum, $profit, $payback_ratio, $power_energy, $length, $network_cord, $power, $frequency_hits, $photo, $photo_alias, $comment, $count)
    {
        if ($model === '') {
            Yii::error('Не передано модель оборудования, model: ' . serialize($model), __METHOD__);
            return [
                'status' => 'ERROR',
                'msg' => 'Не передано наименование оборудования',
            ];
        }

        if ($mark === '') {
            Yii::error('Не передана марка оборудования, mark: ' . serialize($mark), __METHOD__);
            return [
                'status' => 'ERROR',
                'msg' => 'Не передано наименование оборудования',
            ];
        }

        if ($status === '') {
            Yii::error('Не передан идентификатор статуса, status: ' . serialize($status), __METHOD__);
            return [
                'status' => 'ERROR',
                'msg' => 'Не передан идентификатор статуса',
            ];
        }

        if ($discount === '' || $discount === null) {
            Yii::error('Не передан идентификатор скидки, discount: ' . serialize($discount), __METHOD__);
            return [
                'status' => 'ERROR',
                'msg' => 'Не указан размер скидки',
            ];
        }

        if ($stock === '') {
            Yii::error('Не передан идентификатор склада, stock: ' . serialize($stock), __METHOD__);
            return [
                'status' => 'ERROR',
                'msg' => 'Не передан идентификатор склада',
            ];
        }

        if ($equipmentsType === '') {
            Yii::error('Не передан тип оборудования, equipmentsType: ' . serialize($equipmentsType), __METHOD__);
            return [
                'status' => 'ERROR',
                'msg' => 'Не передан тип оборудования',
            ];
        }

        if ($equipmentsCategory === '') {
            Yii::error('Не передана категория оборудования, equipmentsCategory: ' . serialize($equipmentsCategory), __METHOD__);
            return [
                'status' => 'ERROR',
                'msg' => 'Не передана категория оборудования',
            ];
        }

        $i = 0;
        while ($count > $i) {
            $newEquipment = new Equipments();
            $newEquipment->status = $status;
            $newEquipment->mark = $mark;
            $newEquipment->model = $model;
            $newEquipment->stock_id = $stock;
            $newEquipment->type = $equipmentsType;
            $newEquipment->category_id = $equipmentsCategory;
            $newEquipment->tool_number = $tool_number;
            $newEquipment->selling = $selling;
            $newEquipment->selling_price = $selling_price;
            $newEquipment->price_per_day = $price_per_day;
            $newEquipment->revenue = $revenue;
            $newEquipment->degree_wear = $degree_wear;
            $newEquipment->discount = $discount;
            $newEquipment->rentals = $rentals;
            $newEquipment->repairs = $repairs;
            $newEquipment->repairs_sum = $repairs_sum;
            $newEquipment->profit = $profit;
            $newEquipment->payback_ratio = $payback_ratio;
            $newEquipment->photo = $photo;
            $newEquipment->photo_alias = $photo_alias;
            $newEquipment->date_create = date('Y-m-d H:i:s');

            try {
                if (!$newEquipment->save(false)) {
                    Yii::error('Ошибка при добавлении оборудования: ' . serialize($newEquipment->getErrors()), __METHOD__);
                    return false;
                }
            } catch (\Exception $e) {
                Yii::error('Поймали Exception при добавлении оборудования: ' . serialize($e->getMessage()), __METHOD__);
                return false;
            }

            $newEquipmentsInfo = new EquipmentsInfo();
            $newEquipmentsInfo->equipments_id = $newEquipment->id;
            $newEquipmentsInfo->power_energy = $power_energy;
            $newEquipmentsInfo->length = $length;
            $newEquipmentsInfo->network_cord = $network_cord;
            $newEquipmentsInfo->power = $power;
            $newEquipmentsInfo->comment = $comment;
            $newEquipmentsInfo->frequency_hits = $frequency_hits;

            try {
                if (!$newEquipmentsInfo->save(false)) {
                    Yii::error('Ошибка при добавлении дополнительной информации об оборудовании: ' . serialize($newEquipmentsInfo->getErrors()), __METHOD__);
                    return false;
                }
            } catch (\Exception $e) {
                Yii::error('Поймали Exception при добавлении дополнительной информации об оборудовании: ' . serialize($e->getMessage()), __METHOD__);
                return false;
            }

            $i++;
        }

        return [
            'status' => 'SUCCESS',
            'msg' => 'Оборудование успешно добавлено'
        ];
    }

    /**
     * Функция добавления оборудования для спроса
     * @param $model
     * @param $stock
     * @return array|bool
     */
    public static function AddEquipmentMini($model, $stock)
    {
        if ($model === '') {
            Yii::error('Не передано модель оборудования, model: ' . serialize($model), __METHOD__);
            return [
                'status' => 'ERROR',
                'msg' => 'Не передано наименование оборудования',
            ];
        }

        if ($stock === '') {
            Yii::error('Не передан идентификатор склада, stock: ' . serialize($stock), __METHOD__);
            return [
                'status' => 'ERROR',
                'msg' => 'Не передан идентификатор склада',
            ];
        }

        $newEquipment = new EquipmentsDemand();
        $newEquipment->model = $model;
        $newEquipment->stock_id = $stock;

        try {
            if (!$newEquipment->save(false)) {
                Yii::error('Ошибка при добавлении оборудования: ' . serialize($newEquipment->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при добавлении оборудования: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        return [
            'status' => 'SUCCESS',
            'msg' => 'Оборудование успешно добавлено'
        ];
    }

    /**
     * Функция добавления фотографии оборудования
     * @param $file
     * @param $file_name
     * @return array|bool
     */
    public static function AddEquipmentPhoto($file_name, $file)
    {
        if ($file_name === '') {
            Yii::error('Не передано наименование фотографии, file_name: ' . serialize($file_name), __METHOD__);
            return [
                'status' => 'ERROR',
                'msg' => 'Не передано наименование фотографии',
            ];
        }

        if ($file === '') {
            Yii::error('Не передано содержимое фотографии, file: ' . serialize($file), __METHOD__);
            return [
                'status' => 'ERROR',
                'msg' => 'Не передано содержимое фотографии',
            ];
        }

        $uploadFile = dirname(__FILE__) . "/../../web/uploads/" . $file_name;

        if (!file_exists($uploadFile)) {
            $fp = fopen($uploadFile, "w"); // ("r" - считывать "w" - создавать "a" - добовлять к тексту),мы создаем файл
            fwrite($fp, base64_decode($file));
            fclose($fp);
        }

        return [
            'status' => 'SUCCESS',
            'msg' => 'Фотография успешно добавлена'
        ];

    }

    /**
     * @return array
     */
    public static function GetEquipmentsMark()
    {
        Yii::info('Запуск функции GetEquipmentsMark', __METHOD__);
        $result = [];

        $equipmentsMarkList = EquipmentsMark::find()->orderBy('name')->all();

        if (!is_array($equipmentsMarkList)) {
            Yii::error('Список марок оборудования пуст', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Список марок оборудования пуст'
            ];
        }

        /**
         * @var EquipmentsMark $value
         */
        foreach ($equipmentsMarkList as $value) {
            $result[] = [
                'val' => $value->id,
                'name' => $value->name
            ];
        }

        Yii::info('Список марок оборудования получен', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Список марок оборудования получен',
            'data' => $result
        ];
    }

    /**
     * Функция изменения оборудования
     * @param $id
     * @param $model
     * @param $mark
     * @param $new_stock
     * @param $old_stock
     * @param $reason_change_stock
     * @param $equipmentsType
     * @param $equipmentsCategory
     * @param $count
     * @param $tool_number
     * @param $selling_price
     * @param $price_per_day
     * @param $revenue
     * @param $degree_wear
     * @param $discount
     * @param $rentals
     * @param $profit
     * @param $payback_ratio
     * @param $power_energy
     * @param $length
     * @param $network_cord
     * @param $power
     * @param $frequency_hits
     * @param $photo_alias
     * @param $new_status ,
     * @param $old_status ,
     * @param $reason_change_status
     * @param $amount_repair
     * @param $cash_box
     * @param $sale_amount
     * @return array|bool
     * @throws \yii\base\InvalidConfigException
     */
    public static function changeEquipment($id, $model, $mark, $new_stock, $old_stock, $reason_change_stock, $equipmentsType, $equipmentsCategory, $count, $tool_number, $selling_price, $price_per_day, $revenue, $degree_wear, $discount, $rentals, $profit, $payback_ratio, $power_energy, $length, $network_cord, $power, $frequency_hits, $photo_alias, $new_status, $old_status, $reason_change_status, $amount_repair, $cash_box, $sale_amount)
    {
        if ($model === '') {
            Yii::error('Не передано модель оборудования, model: ' . serialize($model), __METHOD__);
            return [
                'status' => 'ERROR',
                'msg' => 'Не передано наименование оборудования',
            ];
        }

        if ($mark === '') {
            Yii::error('Не передана марка оборудования, mark: ' . serialize($mark), __METHOD__);
            return [
                'status' => 'ERROR',
                'msg' => 'Не передано марка оборудования',
            ];
        }

        if ($discount === '') {
            Yii::error('Не передан идентификатор скидки, discount: ' . serialize($discount), __METHOD__);
            return [
                'status' => 'ERROR',
                'msg' => 'Не передан идентификатор скидки',
            ];
        }

        if ($new_stock === '') {
            Yii::error('Не передан идентификатор склада, stock: ' . serialize($new_stock), __METHOD__);
            return [
                'status' => 'ERROR',
                'msg' => 'Не передан идентификатор склада',
            ];
        }

        if ($equipmentsType === '') {
            Yii::error('Не передан тип оборудования, equipmentsType: ' . serialize($equipmentsType), __METHOD__);
            return [
                'status' => 'ERROR',
                'msg' => 'Не передан тип оборудования',
            ];
        }

        if ($equipmentsCategory === '') {
            Yii::error('Не передана категория оборудования, equipmentsCategory: ' . serialize($equipmentsCategory), __METHOD__);
            return [
                'status' => 'ERROR',
                'msg' => 'Не передана категория оборудования',
            ];
        }

        if ($new_stock !== $old_stock && $reason_change_stock === '') {
            Yii::error('Необходимо указать причину изменения склада, reason_change_stock: ' . serialize($reason_change_stock), __METHOD__);
            return [
                'status' => 'ERROR',
                'msg' => 'Необходимо указать причину изменения склада',
            ];
        }

        if ($new_status === '') {
            Yii::error('Не передан статус, new_status: ' . serialize($new_status), __METHOD__);
            return [
                'status' => 'ERROR',
                'msg' => 'Не передан статус',
            ];
        }

        if ($new_status !== $old_status && $reason_change_status === '') {
            if ($new_status === 4 && $old_status === 2) {
                if ($amount_repair === '') {
                    Yii::error('Необходимо указать сумму ремонта, amount_repair: ' . serialize($amount_repair), __METHOD__);
                    return [
                        'status' => 'ERROR',
                        'msg' => 'Необходимо указать сумму ремонта',
                    ];
                }

                if ($cash_box === null) {
                    Yii::error('Необходимо указать кассу, sale_amount: ' . serialize($cash_box), __METHOD__);
                    return [
                        'status' => 'ERROR',
                        'msg' => 'Необходимо указать кассу',
                    ];
                }
            }

            if ($new_status !== 6) {
                if ($reason_change_status === '') {
                    Yii::error('Необходимо указать причину изменения статуса, reason_change_status: ' . serialize($reason_change_status), __METHOD__);
                    return [
                        'status' => 'ERROR',
                        'msg' => 'Необходимо указать причину изменения статуса',
                    ];
                }
            } else {
                if ($sale_amount === '') {
                    Yii::error('Необходимо указать сумму продажи, sale_amount: ' . serialize($sale_amount), __METHOD__);
                    return [
                        'status' => 'ERROR',
                        'msg' => 'Необходимо указать сумму продажи',
                    ];
                }

                if ($cash_box === null) {
                    Yii::error('Необходимо указать кассу, cash_box: ' . serialize($cash_box), __METHOD__);
                    return [
                        'status' => 'ERROR',
                        'msg' => 'Необходимо указать кассу',
                    ];
                }
            }
        }

        /**
         * @var Equipments $equipment
         */
        $equipment = Equipments::find()->where('id=:id', [':id' => $id])->one();

        if (!is_object($equipment)) {
            Yii::error('Оборудование не найдено, id: ' . serialize($id), __METHOD__);
            return [
                'status' => 'ERROR',
                'msg' => 'Оборудование не найдено',
            ];
        }

        // количетсво ремонтов
        $repairCurrent = $new_status !== $old_status && $new_status === 2 ? ++$equipment->repairs : $equipment->repairs;

        $equipment->mark = $mark;
        $equipment->model = $model;
        $equipment->stock_id = $new_stock;
        $equipment->type = $equipmentsType;
        $equipment->category_id = $equipmentsCategory;
        $equipment->count = $count;
        $equipment->status = $new_status;
        $equipment->tool_number = $tool_number;
        $equipment->selling_price = $selling_price;
        $equipment->price_per_day = $price_per_day;
        $equipment->revenue = $revenue;
        $equipment->degree_wear = $degree_wear;
        $equipment->discount = $discount;
        $equipment->rentals = $rentals;
        $equipment->repairs = $repairCurrent;
        $equipment->repairs_sum = $amount_repair;
        $equipment->profit = $profit;
        $equipment->payback_ratio = $payback_ratio;
        $equipment->photo_alias = $photo_alias;

        try {
            if (!$equipment->save(false)) {
                Yii::error('Ошибка при изменении оборудования: ' . serialize($equipment->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при изменении оборудования: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        /**
         * @var EquipmentsInfo $equipmentsInfo
         */
        $equipmentsInfo = EquipmentsInfo::find()->where('equipments_id=:id', [':id' => $id])->one();

        if (!is_object($equipmentsInfo)) {
            Yii::error('Информация об оборудовании не найдено, id: ' . serialize($id), __METHOD__);
            return [
                'status' => 'ERROR',
                'msg' => 'Оборудование не найдено',
            ];
        }

        $equipmentsInfo->power_energy = $power_energy;
        $equipmentsInfo->length = $length;
        $equipmentsInfo->network_cord = $network_cord;
        $equipmentsInfo->power = $power;
        $equipmentsInfo->frequency_hits = $frequency_hits;

        try {
            if (!$equipmentsInfo->save(false)) {
                Yii::error('Ошибка при изменении дополнительной информации об оборудовании: ' . serialize($equipmentsInfo->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при изменении дополнительной информации об оборудовании: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        if ($new_stock !== $old_stock) {
            Yii::info('Запись  информации об изменении склада');

            /**
             * @var Stock $new_stock_name
             */
            $new_stock_name = Stock::find()->where('id=:id', [':id' => $new_stock])->one();

            if (!is_object($new_stock_name)) {
                Yii::error('Склад не найден, new_stock: ' . serialize($new_stock), __METHOD__);
                return [
                    'status' => 'ERROR',
                    'msg' => 'Склад не найден',
                ];
            }

            /**
             * @var Stock $old_stock_name
             */
            $old_stock_name = Stock::find()->where('id=:id', [':id' => $old_stock])->one();

            if (!is_object($old_stock_name)) {
                Yii::error('Склад не найден, old_stock: ' . serialize($old_stock), __METHOD__);
                return [
                    'status' => 'ERROR',
                    'msg' => 'Склад не найден',
                ];
            }

            $check = self::addHistory($id, 1, $old_stock_name->name, $new_stock_name->name, $reason_change_stock);

            if (!is_array($check) || !isset($check['status']) || $check['status'] != 'SUCCESS') {
                Yii::error('Ошибка при изменении оборудования', __METHOD__);

                if (is_array($check) && isset($check['status']) && $check['status'] === 'ERROR') {
                    return $check;
                }

                return [
                    'status' => 'ERROR',
                    'msg' => 'Ошибка при изменении оборудования',
                ];
            }
        }


        if ($new_status !== $old_status) {
            Yii::info('Запись информации об изменении статуса');

            $check = self::addHistoryChangeStatus($id, $new_status, $old_status, $reason_change_status, $amount_repair, $cash_box, $sale_amount);

            if (!is_array($check) || !isset($check['status']) || $check['status'] != 'SUCCESS') {
                Yii::error('Ошибка при изменении статуса', __METHOD__);

                if (is_array($check) && isset($check['status']) && $check['status'] === 'ERROR') {
                    return $check;
                }

                return [
                    'status' => 'ERROR',
                    'msg' => 'Ошибка при изменении статуса',
                ];
            }
        }

        return [
            'status' => 'SUCCESS',
            'msg' => 'Оборудование успешно изменено'
        ];

    }

    /**
     * Добавление записи в историю изменений
     * @param $eq_id
     * @param $type_changes
     * @param $old_params
     * @param $new_params
     * @param $reason
     * @return array|bool
     * @throws \yii\base\InvalidConfigException
     */
    public static function addHistory($eq_id, $type_changes, $old_params, $new_params, $reason)
    {
        Yii::info('Запуск функции добавления записи в историю изменений оборудования', __METHOD__);

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

        $new_records = new EquipmentsHistory();
        $new_records->equipments_id = $eq_id;
        $new_records->type_change = $type_changes;
        $new_records->old_params = $old_params;
        $new_records->new_params = $new_params;
        $new_records->reason = $reason;
        $new_records->user_id = $session->user_id;
        $new_records->date_create = date('Y-m-d H:i:s');

        try {
            if (!$new_records->save(false)) {
                Yii::error('Ошибка при добавления записи в историю изменений оборудования: ' . serialize($new_records->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при добавления записи в историю изменений оборудования: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        Yii::info('Запись успешно добавлена', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Запись успешно добавлена'
        ];
    }

    /**
     * Добавление записи в историю изменений статуса
     * @param $id
     * @param $new_status
     * @param $old_status
     * @param $reason_change_status
     * @param $amount_repair
     * @param $sale_amount
     * @param $cashBox
     * @return array|bool
     * @throws \yii\base\InvalidConfigException
     */
    public static function addHistoryChangeStatus($id, $new_status, $old_status, $reason_change_status, $amount_repair, $cashBox, $sale_amount)
    {
        Yii::info('Запуск функции добавления записи в историю изменений статуса оборудования', __METHOD__);

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

        $new_records = new EquipmentsHistoryChangeStatus();
        $new_records->equipments_id = $id;
        $new_records->old_status = $old_status;
        $new_records->new_status = $new_status;
        $new_records->reason = $reason_change_status;
        $new_records->user_id = $session->user_id;
        $new_records->sum = $amount_repair === 0 ? $sale_amount : $amount_repair;
        $new_records->cashBox_id = $cashBox;
        $new_records->date_create = date('Y-m-d H:i:s');

        try {
            if (!$new_records->save(false)) {
                Yii::error('Ошибка при добавления записи в историю изменений статуса оборудования: ' . serialize($new_records->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при добавления записи в историю изменений статуса оборудования: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        if ($amount_repair !== 0 || $sale_amount !== 0) {
            if ($amount_repair !== '') {
                $sum = (float)$amount_repair;
                $revertSum = true;
            } else {
                $sum = (float)$amount_repair;
                $revertSum = false;
            }

            $check_update = PayClass::updateCashBox($cashBox, $sum, $revertSum);

            if (!is_array($check_update) || !isset($check_update['status']) || $check_update['status'] != 'SUCCESS') {
                Yii::error('Ошибка при обновлении кассы', __METHOD__);

                return [
                    'status' => 'ERROR',
                    'msg' => 'Ошибка при обновлении кассы',
                ];
            }
        }

        if ($amount_repair !== 0) {
            Yii::info('Добавляем запись в финансы', __METHOD__);

            /**
             * @var Equipments $eq
             */
            $eq = Equipments::find()->where('id=:id', [':id' => $id])->one();

            if (!is_object($eq)) {
                Yii::error('Ошибка при опредении оборудования', __METHOD__);

                return [
                    'status' => 'ERROR',
                    'msg' => 'Ошибка при опредении оборудования'
                ];
            }

            $name = $eq->type0->name . ' ' . $eq->mark0->name . ' ' . $eq->model;
            $branch = $eq->stock->branch->id;

            $check_update = FinanceClass::addFinance('', $name, 5, 1, $amount_repair, $cashBox, $branch, $id);

            if (!is_array($check_update) || !isset($check_update['status']) || $check_update['status'] != 'SUCCESS') {
                Yii::error('Ошибка при обновлении кассы', __METHOD__);

                return [
                    'status' => 'ERROR',
                    'msg' => 'Ошибка при обновлении кассы',
                ];
            }
        }

        if ($new_status !== $old_status && $new_status === 6) {
            Yii::info('Добавляем запись в финансы', __METHOD__);

            /**
             * @var Equipments $eq
             */
            $eq = Equipments::find()->where('id=:id', [':id' => $id])->one();

            if (!is_object($eq)) {
                Yii::error('Ошибка при опредении оборудования', __METHOD__);

                return [
                    'status' => 'ERROR',
                    'msg' => 'Ошибка при опредении оборудования'
                ];
            }

            $name = $eq->type0->name . ' ' . $eq->mark0->name . ' ' . $eq->model;
            $branch = $eq->stock->branch->id;

            $check_update = FinanceClass::addFinance('', $name, 10, 2, $sale_amount, $cashBox, $branch, $id);

            if (!is_array($check_update) || !isset($check_update['status']) || $check_update['status'] != 'SUCCESS') {
                Yii::error('Ошибка при обновлении кассы', __METHOD__);

                return [
                    'status' => 'ERROR',
                    'msg' => 'Ошибка при обновлении кассы',
                ];
            }
        }


        Yii::info('Запись успешно добавлена', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Запись успешно добавлена'
        ];
    }

    /**
     * Добавление нового статуса для оборудования
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
            $new_status = EquipmentsStatus::find()->where('id=:id', [':id' => $val])->one();

            if (!is_object($new_status)) {
                Yii::error('Передан некорректный идентификатор, id:' . serialize($val), __METHOD__);

                return [
                    'status' => 'ERROR',
                    'msg' => 'Передан некорректный идентификатор',
                ];
            }
        } else {
            $new_status = new EquipmentsStatus();
        }

        $new_status->name = $name;
        $new_status->color = $color;

        try {
            if (!$new_status->save(false)) {
                Yii::error('Ошибка при добавлении нового статуса для оборудования: ' . serialize($new_status->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при добавлении нового статуса для оборудования: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        Yii::info('Статус для оборудования успешно добавлен', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => $val === '' ? 'Статус для оборудования успешно добавлен' : 'Статус для оборудования успешно обновлен'
        ];
    }

    /**
     * Добавление новой категории для оборудования
     * @param $name
     * @param $val
     * @return bool|array
     */
    public
    static function AddCategory($name, $val)
    {
        Yii::info('Запуск функции добавления новой категории для оборудования', __METHOD__);

        if ($name === '') {
            Yii::error('Ни передано наименование категории, name:' . serialize($name), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ни передано наименование категории',
            ];
        }

        if ($val !== '') {
            $new = EquipmentsCategory::find()->where('id=:id', [':id' => $val])->one();

            if (!is_object($new)) {
                Yii::error('Передан некорректный идентификатор, id:' . serialize($val), __METHOD__);

                return [
                    'status' => 'ERROR',
                    'msg' => 'Передан некорректный идентификатор',
                ];
            }
        } else {
            $new = new EquipmentsCategory();
        }

        $new->name = $name;

        try {
            if (!$new->save(false)) {
                Yii::error('Ошибка при добавлении новой категории для оборудования: ' . serialize($new->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при добавлении новой категории для оборудования: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        Yii::info('Категория для оборудования успешно добавлен', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => $val === '' ? 'Категория для оборудования успешно добавлена' : 'Категория для оборудования успешно обновлена'
        ];
    }

    /**
     * Добавление нового типа для оборудования
     * @param $name
     * @param $val
     * @param $category_id
     * @return bool|array
     */
    public
    static function AddType($name, $val, $category_id)
    {
        Yii::info('Запуск функции добавления нового типа для оборудования', __METHOD__);

        if ($name === '') {
            Yii::error('Ни передано наименование типа, name:' . serialize($name), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ни передано наименование типа',
            ];
        }

        if ($category_id === '') {
            Yii::error('Ни передан идентификатор категории, category_id:' . serialize($category_id), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ни передан идентификатор категории',
            ];
        }

        if ($val !== '') {
            $new = EquipmentsType::find()->where('id=:id', [':id' => $val])->one();

            if (!is_object($new)) {
                Yii::error('Передан некорректный идентификатор, id:' . serialize($val), __METHOD__);

                return [
                    'status' => 'ERROR',
                    'msg' => 'Передан некорректный идентификатор',
                ];
            }
        } else {
            $new = new EquipmentsType();
        }

        $new->name = $name;
        $new->category_id = $category_id;

        try {
            if (!$new->save(false)) {
                Yii::error('Ошибка при добавлении нового типа для оборудования: ' . serialize($new->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при добавлении нового типа для оборудования: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        Yii::info('Тип для оборудования успешно добавлен', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => $val === '' ? 'Тип для оборудования успешно добавлена' : 'Тип для оборудования успешно обновлена'
        ];
    }

    /**
     * Добавление новой марки для оборудования
     * @param $name
     * @param $val
     * @return bool|array
     */
    public
    static function AddMark($name, $val)
    {
        Yii::info('Запуск функции добавления новой марки для оборудования', __METHOD__);

        if ($name === '') {
            Yii::error('Ни передано наименование марки, name:' . serialize($name), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ни передано наименование марки',
            ];
        }

        if ($val !== '') {
            $new = EquipmentsMark::find()->where('id=:id', [':id' => $val])->one();

            if (!is_object($new)) {
                Yii::error('Передан некорректный идентификатор, id:' . serialize($val), __METHOD__);

                return [
                    'status' => 'ERROR',
                    'msg' => 'Передан некорректный идентификатор',
                ];
            }
        } else {
            $new = new EquipmentsMark();
        }

        $new->name = $name;

        try {
            if (!$new->save(false)) {
                Yii::error('Ошибка при добавлении новой марки для оборудования: ' . serialize($new->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при добавлении новой марки для оборудования: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        Yii::info('Марка для оборудования успешно добавлена', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => $val === '' ? 'Марка для оборудования успешно добавлена' : 'Марка для оборудования успешно обновлена'
        ];
    }

    /**
     * Удаление статуса оборудования
     * @param $id ,
     * @return bool|array
     */
    public
    static function DeleteStatus($id)
    {
        Yii::info('Запуск функции удаления статуса оборудования', __METHOD__);

        if ($id === '') {
            Yii::error('Ни передано идентификатор статуса, id:' . serialize($id), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ни передан идентификатор статуса',
            ];
        }

        $check_status = Equipments::find()->where('status=:status', [':status' => $id])->one();

        if (is_object($check_status)) {
            Yii::error('Данный статус нельзя удалить. Статус используется:' . serialize($id), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Данный статус нельзя удалить. Статус используется',
            ];
        }

        try {
            EquipmentsStatus::deleteAll('id=:id', array(':id' => $id));
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
     * Удаление категории оборудования
     * @param $id ,
     * @return bool|array
     */
    public
    static function DeleteCategory($id)
    {
        Yii::info('Запуск функции удаления категории оборудования', __METHOD__);

        if ($id === '') {
            Yii::error('Ни передано идентификатор категории, id:' . serialize($id), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ни передан идентификатор категории',
            ];
        }

        $check_status = Equipments::find()->where('category_id=:id', [':id' => $id])->one();

        if (is_object($check_status)) {
            Yii::error('Данную категорию нельзя удалить. Категория используется:' . serialize($id), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Данную категорию нельзя удалить. Категория используется',
            ];
        }

        try {
            EquipmentsCategory::deleteAll('id=:id', array(':id' => $id));
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при удалении категории: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        Yii::info('Категория успешно удалена', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Категория успешно удалена'
        ];
    }

    /**
     * Удаление типа оборудования
     * @param $id ,
     * @return bool|array
     */
    public static function DeleteType($id)
    {
        Yii::info('Запуск функции удаления типа оборудования', __METHOD__);

        if ($id === '') {
            Yii::error('Ни передано идентификатор типа, id:' . serialize($id), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ни передан идентификатор типа',
            ];
        }

        $check_status = Equipments::find()->where('type=:id', [':id' => $id])->one();

        if (is_object($check_status)) {
            Yii::error('Данный тип нельзя удалить. Тип используется:' . serialize($id), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Данный тип нельзя удалить. Тип используется',
            ];
        }

        try {
            EquipmentsType::deleteAll('id=:id', array(':id' => $id));
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при удалении типа: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        Yii::info('Тип успешно удален', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Тип успешно удален'
        ];
    }

    /**
     * Удаление оборудования
     * @param $id ,
     * @return bool|array
     */
    public static function DeleteEquipment($id)
    {
        Yii::info('Запуск функции удаления типа оборудования', __METHOD__);

        if ($id === '') {
            Yii::error('Ни передано идентификатор типа, id:' . serialize($id), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ни передан идентификатор типа',
            ];
        }

        /**
         * @var Equipments $equipments
         */
        $equipments = Equipments::find()->where('id=:id', [':id' => $id])->one();

        if (!is_object($equipments)) {
            Yii::error('Оборудование не найдено. id:' . serialize($id), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Оборудование не найдено',
            ];
        }

        $equipments->is_not_active = 1;

        try {
            if (!$equipments->save(false)) {
                Yii::error('Ошибка при удалении оборудования: ' . serialize($equipments->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при удалении оборудования: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        Yii::info('Оборудование успешно удалено', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Оборудование успешно удалено'
        ];
    }

    /**
     * Удаление марки оборудования
     * @param $id ,
     * @return bool|array
     */
    public static function DeleteMark($id)
    {
        Yii::info('Запуск функции удаления марки оборудования', __METHOD__);

        if ($id === '') {
            Yii::error('Ни передано идентификатор марки, id:' . serialize($id), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ни передан идентификатор марки',
            ];
        }

        $check_status = Equipments::find()->where('mark=:id', [':id' => $id])->one();

        if (is_object($check_status)) {
            Yii::error('Данную марку нельзя удалить. Марка используется:' . serialize($id), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Данную марку нельзя удалить. Марка используется',
            ];
        }

        try {
            EquipmentsMark::deleteAll('id=:id', array(':id' => $id));
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при удалении марки: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        Yii::info('Марка успешно удалена', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Марка успешно удалена'
        ];
    }

    /**
     * Функция изменения статуса у оборудования
     * @param $id_eq
     * @param $status
     * @param bool $rent_start
     * @param bool $rent_end
     * @return array|bool
     * @throws \yii\base\InvalidConfigException
     */
    public static function changeStatus($id_eq, $status, $rent_start = false, $rent_end = false)
    {
        Yii::info('Запуск функции изменения статуса у оборудования', __METHOD__);

        /**
         * @var Equipments $equipments
         */
        $equipments = Equipments::find()->where('id=:id', [':id' => $id_eq])->one();

        if (!is_object($equipments)) {
            Yii::error('Ошибка при получении оборудования', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при получении оборудования'
            ];
        }

        $old_status = $equipments->status;
        $equipments->status = $status;
        $equipments->rentals = $status === 1 ? ++$equipments->rentals : $equipments->rentals;

        if ($rent_start) {
            $txt = 'с ' . date('d.m.Y H:i:s', strtotime($rent_start)) . ' до ' . date('d.m.Y H:i:s', strtotime($rent_end));
            $equipments->dop_status = $status === 1 ? 'В аренде ' . $txt : 'Бронь ' . $txt;
        }

        try {
            if (!$equipments->save(false)) {
                Yii::error('Ошибка при сохранении статуса оборудования: ' . serialize($equipments->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при сохранении статуса оборудования: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        $check = self::addHistoryChangeStatus($equipments->id, $equipments->status, $old_status, 'Система', 0, 0, 0);

        if (!is_array($check) || !isset($check['status']) || $check['status'] != 'SUCCESS') {
            Yii::error('Ошибка при изменении статуса', __METHOD__);

            if (is_array($check) && isset($check['status']) && $check['status'] === 'ERROR') {
                return $check;
            }

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при изменении статуса',
            ];
        }

        return [
            'status' => 'SUCCESS',
            'msg' => 'Оборудование успешно изменено'
        ];
    }

    /**
     * Функция обновления финансовой информаци об оборудовании
     * @param $id_eq
     * @return array|bool
     */
    public static function updateFinanceEquipment($id_eq)
    {
        Yii::info('Запуск обновления финансовой информаци об оборудовании', __METHOD__);

        /**
         * @var Equipments $equipments
         */
        $equipments = Equipments::find()->where('id=:id', [':id' => $id_eq])->one();

        if (!is_object($equipments)) {
            Yii::info('Ошибка при получении оборудования', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ошибка при получении оборудования'
            ];
        }

        $equipments->profit = (float)$equipments->revenue - (float)$equipments->repairs_sum;
        $equipments->payback_ratio = round($equipments->profit == 0 ? 0 : (float)$equipments->profit / (float)$equipments->selling_price, 2);

        try {
            if (!$equipments->save(false)) {
                Yii::error('Ошибка при сохранении информации по оборудованию: ' . serialize($equipments->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при сохранении информации по оборудованию: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        return [
            'status' => 'SUCCESS',
            'msg' => 'Оборудование успешно изменено'
        ];
    }
}