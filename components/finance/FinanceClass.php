<?php
/**
 * Управление финансами
 */

namespace app\components\finance;

use app\components\Session\Sessions;
use app\models\Finance;
use app\models\FinanceCashbox;
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
            $check_flag = FinanceShowField::find()->where('finance_field_id=:finance_field_id and user_id=:user_id', [':finance_field_id' => $value->id, ':user_id' => $session->user_id])->orderBy('id')->one();

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
                $newVal->finance_field_id = $value->id;

                try {
                    if (!$newVal->save(false)) {
                        Yii::error('Ошибка при изменении отображения поля: ' . serialize($newVal->getErrors()), __METHOD__);
                        return false;
                    }
                } catch (\Exception $e) {
                    Yii::error('Поймали Exception при изменении отображения поля: ' . serialize($e->getMessage()), __METHOD__);
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

    /**
     * Получение касс финансов
     * @return bool|array
     */
    public static function GetFinanceCashBox()
    {
        Yii::info('Запуск функции GetFinanceCashBox', __METHOD__);
        $result = [];

        $equipmentsTypeList = FinanceCashbox::find()->orderBy('id')->all();

        if (!is_array($equipmentsTypeList)) {
            Yii::error('Список касс финансов пуст', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Список касс финансов пуст'
            ];
        }

        /**
         * @var FinanceCashbox $value
         */
        foreach ($equipmentsTypeList as $value) {
            $result[] = [
                'val' => $value->id,
                'name' => $value->name,
                'sum' => $value->sum
            ];
        }

        Yii::info('Список касс финансов получен', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Список касс финансов получен',
            'data' => $result
        ];
    }

    public static function GetFinance($like, $category, $cashBox, $type, $sum_start, $sum_end, $date_start, $date_end)
    {
        Yii::info('Запуск функции GetFinance', __METHOD__);

        $listFilter = [];
        $params = [];
        $result = [];

        if ($like !== '' and $like !== null) {
            Yii::info('Параметр like: ' . serialize($like), __METHOD__);
            $like = '%' . $like . '%';
            $listFilter[] = 'name like :like';
            $params[':like'] = $like;
        }

        if ($category !== '' and $category !== null) {
            Yii::info('Параметр category: ' . serialize($category), __METHOD__);
            $listFilter[] = 'category_id=:category';
            $params[':category'] = $category;
        }

        if ($cashBox !== 1 and $cashBox !== null) {
            Yii::info('Параметр cashBox: ' . serialize($cashBox), __METHOD__);
            $listFilter[] = 'cashBox_id=:cashBox';
            $params[':cashBox'] = $cashBox;
        }

        if ($type !== '' and $type !== null) {
            Yii::info('Параметр type: ' . serialize($type), __METHOD__);
            $listFilter[] = 'type_id=:type';
            $params[':type'] = $type;
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

        if ($sum_start !== '' and $sum_start !== null) {
            Yii::info('Параметр sum_start: ' . serialize($sum_start), __METHOD__);
            $listFilter[] = 'sum<:sum_start';
            $params[':sum_start'] = (int)$sum_start;
        }

        if ($sum_end !== '' and $sum_end !== null) {
            Yii::info('Параметр sum_end: ' . serialize($sum_end), __METHOD__);
            $listFilter[] = 'sum>:sum_end';
            $params[':sum_end'] = (int)$sum_end;
        }

        if (!empty($listFilter)) {
            $financeList = Finance::find()->where(implode(" and ", $listFilter), $params)->orderBy('date_create desc')->all();
        } else {
            $financeList = Finance::find()->orderBy('date_create desc')->all();
        }

        if (empty($financeList)) {
            Yii::info('Список финансов пуст', __METHOD__);

            return [
                'status' => 'SUCCESS',
                'msg' => 'Список финансов пуст',
                'data' => $result
            ];
        }

        /**
         * @var Finance $finance
         */
        foreach ($financeList as $finance) {
            $result[] = [
                'id' => $finance->id,
                'name' => $finance->name,
                'category_id' => $finance->category_id,
                'type' => $finance->type->name,
                'date_create' => date('d.m.Y', strtotime($finance->date_create)),
                'payer' => $finance->payer->name,
                'sum' => $finance->sum
            ];
        }

        Yii::info('Список финансов получен', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Список финансов получен',
            'data' => $result
        ];
    }

    /**
     * Изменение категории финансов
     * @param $id
     * @param $finance_category
     * @return bool|array
     */
    public static function UpdateStatus($id, $finance_category)
    {
        Yii::info('Запуск функции UpdateStatus', __METHOD__);

        if ($id === '' || !is_int($finance_category)) {
            Yii::error('Не передан идентификатор финансов, id: ' . serialize($id), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не передан идентификатор финансов',
            ];
        }

        if ($finance_category === '' || !is_int($finance_category)) {
            Yii::error('Передан некорректный идентификатор категории, status: ' . serialize($finance_category), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Передан некорректный идентификатор категории',
            ];
        }

        $check_status = FinanceCategory::find()->where('id=:id', [':id' => $finance_category])->one();

        if (!is_object($check_status)) {
            Yii::error('Передан некорректный идентификатор категории, status:' . serialize($finance_category), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Передан некорректный идентификатор категории',
            ];
        }

        /**
         * @var Finance $finance
         */
        $finance = Finance::find()->where('id=:id', [':id' => $id])->one();

        if (!is_object($finance)) {
            Yii::error('По данному идентификатору не найден клиент, id' . serialize($id), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Организация не найдена',
            ];
        }

        $finance->category_id = $finance_category;

        try {
            if (!$finance->save(false)) {
                Yii::error('Ошибка при обновлении категории финансов: ' . serialize($finance->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при обновлении категории финансов: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        Yii::info('Категория успешно изменена', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Категория успешно изменена'
        ];
    }

    /**
     * Функция добавления финансов
     * @param $name
     * @param $category
     * @param $type
     * @param $date
     * @param $payer
     * @param $sum
     * @param $cashBox
     * @return array|bool
     */
    public static function addFinance($name, $category, $type, $date, $payer, $sum, $cashBox)
    {
        Yii::info('Функция добавления финансов', __METHOD__);

        if ($name === '') {
            Yii::error('Не передано назначение', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не передано назначение'
            ];
        }

        if ($category === '') {
            Yii::error('Не передан идентификатор категории', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не передан идентификатор категории'
            ];
        }

        if ($type === '') {
            Yii::error('Не передан идентификатор типа', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не передан идентификатор типа'
            ];
        }

        if ($date === '') {
            Yii::error('Не передана дата', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не передана дата'
            ];
        }

        if ($payer === '') {
            Yii::error('Не передан идетификатор плательщика', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не передан идетификатор плательщика'
            ];
        }

        if ($sum === '') {
            Yii::error('Не передана сумма', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не передана сумма'
            ];
        }

        if ($cashBox === '') {
            Yii::error('Не передан идентификатор кассы', __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Не передан идентификатор кассы'
            ];
        }

        $checkCategory = FinanceCategory::find()->where('id=:id', [':id' => $category])->one();

        if (!is_object($checkCategory)) {
            Yii::error('Передан некорректный идентификатор категории, id:'.serialize($category), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Передан некорректный идентификатор категории'
            ];
        }

        $checkType = FinanceType::find()->where('id=:id', [':id' => $type])->one();

        if (!is_object($checkType)) {
            Yii::error('Передан некорректный идентификатор типа, id:'.serialize($type), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Передан некорректный идентификатор типа'
            ];
        }

        $checkCashBox = FinanceType::find()->where('id=:id', [':id' => $cashBox])->one();

        if (!is_object($checkCashBox)) {
            Yii::error('Передан некорректный идентификатор кассы, id:'.serialize($cashBox), __METHOD__);

            return [
                'status' => 'ERROR',
                'msg' => 'Передан некорректный идентификатор кассы'
            ];
        }


        $newFinance = new Finance();
        $newFinance->name = $name;
        $newFinance->category_id = $category;
        $newFinance->type_id = $type;
        $newFinance->date_create = date('Y-m-d H:i:s', strtotime($date));
        $newFinance->payer_id = $payer;
        $newFinance->sum = $sum;
        $newFinance->cashBox_id = $cashBox;

        try {
            if (!$newFinance->save(false)) {
                Yii::error('Ошибка при добавлении финансов: ' . serialize($newFinance->getErrors()), __METHOD__);
                return false;
            }
        } catch (\Exception $e) {
            Yii::error('Поймали Exception при добавлении финансов: ' . serialize($e->getMessage()), __METHOD__);
            return false;
        }

        Yii::info('Финансовая запись успешно изменена', __METHOD__);

        return [
            'status' => 'SUCCESS',
            'msg' => 'Финансовая запись успешно изменена'
        ];
    }
}