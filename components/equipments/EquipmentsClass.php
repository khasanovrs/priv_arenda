<?php
/**
 * Управление оборудованием
 */

namespace app\components\equipments;

use app\components\Session\Sessions;
use app\models\Equipments;
use app\models\EquipmentsCategory;
use app\models\EquipmentsField;
use app\models\EquipmentsShowField;
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
     * Получение списка оборудования
     * @return bool|array
     */
    public static function GetEquipments()
    {
        Yii::info('Запуск функции GetEquipments', __METHOD__);
        $result = [];

        $equipmentsTypeList = Equipments::find()->orderBy('id')->all();

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
                'name' => $value->name,
                'category_id' => $value->category_id,
                'stock_id' => $value->stock_id,
                'type' => $value->type,
                'availability' => $value->availability,
                'equipmentscol' => $value->equipmentscol,
                'selling_price' => $value->selling_price,
                'price_per_day' => $value->price_per_day,
                'rentals' => $value->rentals,
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
     * Получение списка полей для оборудования
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public function GetEquipmentFields()
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

            $flag = is_object($check_flag) ? 1 : 0;

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
                        Yii::error('Ошибка при изменени отображения поля: ' . serialize($newVal->getErrors()), __METHOD__);
                        return false;
                    }
                } catch (\Exception $e) {
                    Yii::error('Поймали Exception при изменени отображения поля: ' . serialize($e->getMessage()), __METHOD__);
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
}