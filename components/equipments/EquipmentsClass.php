<?php
/**
 * Управление оборудованием
 */

namespace app\components\equipments;

use app\components\Session\Sessions;
use app\models\Clients;
use app\models\ClientStatus;
use app\models\Equipments;
use app\models\EquipmentsAvailability;
use app\models\EquipmentsCategory;
use app\models\EquipmentsField;
use app\models\EquipmentsInfo;
use app\models\EquipmentsMark;
use app\models\EquipmentsShowField;
use app\models\EquipmentsStatus;
use app\models\EquipmentsType;
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
                'name' => $value->name
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
            $result[] = [
                'val' => $value->id,
                'name' => $value->name
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
                'name' => $value->name
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
     * @return array
     */
    public static function GetEquipments($status, $like, $stock, $equipmentsType, $equipmentsCategory, $count_start, $count_end, $selling_price_start, $selling_price_end, $price_per_day_start, $price_per_day_end, $rentals_start, $rentals_end, $repairs_start, $repairs_end, $repairs_sum_start, $repairs_sum_end, $revenue_start, $revenue_end, $profit_start, $profit_end, $degree_wear_start, $degree_wear_end)
    {
        Yii::info('Запуск функции GetEquipments', __METHOD__);

        $result = [];
        $listFilter = [];
        $params = [];

        if ($status !== '' and $status !== null) {
            Yii::info('Параметр status: ' . serialize($status), __METHOD__);
            $listFilter[] = 'status=:status';
            $params[':status'] = $status;
        }

        if ($like !== '' and $like !== null) {
            Yii::info('Параметр like: ' . serialize($like), __METHOD__);
            $like = '%' . $like . '%';
            $listFilter[] = 'lower(model) like :like or lower(equipments_mark.name) like :like';
            $params[':like'] = strtolower($like);
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
            $listFilter[] = 'category_id=:equipmentsCategory';
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

        if (!empty($listFilter)) {
            $equipmentsTypeList = Equipments::find()->joinWith('mark0')->where(implode(" and ", $listFilter), $params)->orderBy('id desc')->all();
        } else {
            $equipmentsTypeList = Equipments::find()->orderBy('id desc')->all();
        }

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
                'status' => $value->status,
                'count' => $value->count,
                'selling_price' => $value->selling_price,
                'price_per_day' => $value->price_per_day,
                'rentals' => $value->rentals,
                'repairs' => $value->repairs,
                'repairs_sum' => $value->repairs_sum,
                'tool_number' => $value->tool_number,
                'revenue' => $value->revenue,
                'profit' => $value->profit,
                'degree_wear' => $value->degree_wear,
                'payback_ratio' => $value->payback_ratio,
                'date_create' => $value->date_create
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
     * @param $filter
     * @return array
     */
    public static function GetEquipmentsSearch($filter)
    {
        Yii::info('Запуск функции GetEquipmentsSearch', __METHOD__);
        $result = [];

        if ($filter === '') {
            Yii::error('Фильтр не передан', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Фильтр не передан'
            ];
        }

        $filter = strtolower($filter);
        $filter = '%' . $filter . '%';

        $equipments = Equipments::find()->joinWith('mark0')->where('lower(model) like :filter or lower(equipments_mark.name) like :filter', [':filter' => $filter])->orderBy('id desc')->all();

        if (!is_array($equipments)) {
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
            $result[] = [
                'id' => $value->id,
                'name' => $value->type0->name . ' ' . $value->mark0->name . ' ' . $value->model,
                'price_per_day' => $value->price_per_day,
                'count' => $value->count,
                'photo' => $value->photo
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
     * Получение детальной информации об оборудовании
     * @param $equipmentId
     * @return array
     */
    public static function GetEquipmentInfo($equipmentId)
    {
        Yii::info('Запуск функции GetEquipmentInfo', __METHOD__);

        $equipment = Equipments::find()->where('id=:id', [':id' => $equipmentId])->one();

        if (!is_object($equipment)) {
            Yii::error('Оборудование не найдено, id:' . serialize($equipmentId), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Оборудование не найдено'
            ];
        }

        /**
         * @var Equipments $equipment
         */

        $result = [
            'id' => $equipment->id,
            'mark' => $equipment->mark,
            'model' => $equipment->model,
            'category' => $equipment->category_id,
            'stock' => $equipment->stock_id,
            'type' => $equipment->type,
            'discount' => $equipment->discount,
            'status' => $equipment->status,
            'count' => $equipment->count,
            'selling_price' => $equipment->selling_price,
            'price_per_day' => $equipment->price_per_day,
            'rentals' => $equipment->rentals,
            'repairs' => $equipment->repairs,
            'repairs_sum' => $equipment->repairs_sum,
            'tool_number' => $equipment->tool_number,
            'revenue' => $equipment->revenue,
            'profit' => $equipment->profit,
            'degree_wear' => $equipment->degree_wear,
            'payback_ratio' => $equipment->payback_ratio,
            'power_energy' => $equipment->equipmentsInfos[0]->power_energy,
            'length' => $equipment->equipmentsInfos[0]->length,
            'network_cord' => $equipment->equipmentsInfos[0]->network_cord,
            'power' => $equipment->equipmentsInfos[0]->power,
            'frequency_hits' => $equipment->equipmentsInfos[0]->frequency_hits,
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
     * @param $count
     * @param $tool_number
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
     * @return array|bool
     */
    public static function AddEquipment($model, $mark, $status, $stock, $equipmentsType, $equipmentsCategory, $count, $tool_number, $selling_price, $price_per_day, $revenue, $degree_wear, $discount, $rentals, $repairs, $repairs_sum, $profit, $payback_ratio, $power_energy, $length, $network_cord, $power, $frequency_hits, $photo)
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

        if ($discount === '') {
            Yii::error('Не передан идентификатор скидки, discount: ' . serialize($discount), __METHOD__);
            return [
                'status' => 'ERROR',
                'msg' => 'Не передан идентификатор скидки',
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

        if ($count === '') {
            Yii::error('Не передано количество оборудования, count: ' . serialize($count), __METHOD__);
            return [
                'status' => 'ERROR',
                'msg' => 'Не передано количество оборудования',
            ];
        }

        if ($count === '') {
            Yii::error('Не передано количество оборудования, count: ' . serialize($count), __METHOD__);
            return [
                'status' => 'ERROR',
                'msg' => 'Не передано количество оборудования',
            ];
        }

        if ($tool_number === '') {
            Yii::error('Не передан номер оборудования, tool_number: ' . serialize($tool_number), __METHOD__);
            return [
                'status' => 'ERROR',
                'msg' => 'Не передано количество оборудования',
            ];
        }

        $newEquipment = new Equipments();
        $newEquipment->status = $status;
        $newEquipment->mark = $mark;
        $newEquipment->model = $model;
        $newEquipment->stock_id = $stock;
        $newEquipment->type = $equipmentsType;
        $newEquipment->category_id = $equipmentsCategory;
        $newEquipment->count = $count;
        $newEquipment->tool_number = $tool_number;
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

        //@todo указать папку для сохранения фото
        $uploadFile = "/home/fox/" . $file_name;

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

        $equipmentsMarkList = EquipmentsMark::find()->orderBy('id')->all();

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
     * @param $status
     * @param $stock
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
     * @param $repairs
     * @param $repairs_sum
     * @param $profit
     * @param $payback_ratio
     * @param $power_energy
     * @param $length
     * @param $network_cord
     * @param $power
     * @param $frequency_hits
     * @return array|bool
     */
    public static function changeEquipment($id, $model, $mark, $status, $stock, $equipmentsType, $equipmentsCategory, $count, $tool_number, $selling_price, $price_per_day, $revenue, $degree_wear, $discount, $rentals, $repairs, $repairs_sum, $profit, $payback_ratio, $power_energy, $length, $network_cord, $power, $frequency_hits)
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

        if ($discount === '') {
            Yii::error('Не передан идентификатор скидки, discount: ' . serialize($discount), __METHOD__);
            return [
                'status' => 'ERROR',
                'msg' => 'Не передан идентификатор скидки',
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

        if ($count === '') {
            Yii::error('Не передано количество оборудования, count: ' . serialize($count), __METHOD__);
            return [
                'status' => 'ERROR',
                'msg' => 'Не передано количество оборудования',
            ];
        }

        if ($count === '') {
            Yii::error('Не передано количество оборудования, count: ' . serialize($count), __METHOD__);
            return [
                'status' => 'ERROR',
                'msg' => 'Не передано количество оборудования',
            ];
        }

        if ($tool_number === '') {
            Yii::error('Не передан номер оборудования, tool_number: ' . serialize($tool_number), __METHOD__);
            return [
                'status' => 'ERROR',
                'msg' => 'Не передано количество оборудования',
            ];
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

        $equipment->status = $status;
        $equipment->mark = $mark;
        $equipment->model = $model;
        $equipment->stock_id = $stock;
        $equipment->type = $equipmentsType;
        $equipment->category_id = $equipmentsCategory;
        $equipment->count = $count;
        $equipment->tool_number = $tool_number;
        $equipment->selling_price = $selling_price;
        $equipment->price_per_day = $price_per_day;
        $equipment->revenue = $revenue;
        $equipment->degree_wear = $degree_wear;
        $equipment->discount = $discount;
        $equipment->rentals = $rentals;
        $equipment->repairs = $repairs;
        $equipment->repairs_sum = $repairs_sum;
        $equipment->profit = $profit;
        $equipment->payback_ratio = $payback_ratio;

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

        return [
            'status' => 'SUCCESS',
            'msg' => 'Оборудование успешно изменено'
        ];

    }

    /**
     * Добавление нового статуса для оборудования
     * @param $name ,
     * @return bool|array
     */
    public static function AddStatus($name)
    {
        Yii::info('Запуск функции добавления нового статуса для оборудования', __METHOD__);

        if ($name === '') {
            Yii::error('Ни передано наименование статуса, name:' . serialize($name), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Ни передано наименование статуса',
            ];
        }

        $new_status = new EquipmentsStatus();
        $new_status->name = $name;

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
            'msg' => 'Статус для оборудования успешно добавлен'
        ];
    }
}