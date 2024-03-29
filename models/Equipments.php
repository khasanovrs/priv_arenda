<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "equipments".
 *
 * @property int $id
 * @property int $mark
 * @property string $model
 * @property int $category_id идентификатор категории
 * @property int $stock_id
 * @property int $type тип инструмента
 * @property int $discount
 * @property int $status Доступность
 * @property string $count
 * @property string $selling стоимость оборудования
 * @property string $selling_price Цена продажи
 * @property string $price_per_day Цена за сутки
 * @property string $rentals Количество прокатов 
 * @property string $repairs Количество ремонтов
 * @property string $repairs_sum Сумма ремонтов
 * @property string $tool_number Номер инструмента
 * @property string $revenue Выручка
 * @property string $profit Прибыль (выручка - цена покупки - ремонт)
 * @property string $degree_wear Степень износа 
 * @property string $payback_ratio Коэфициент окупаемости
 * @property string $date_create
 * @property string $photo
 * @property string $countHire количество прокатов
 * @property string $photo_alias
 * @property string $is_not_active
 * @property string $dop_status
 * @property string $count_hire
 * @property string $count_repairs
 *
 * @property ApplicationEquipment[] $applicationEquipments
 * @property EquipmentsCategory $category
 * @property Stock $stock
 * @property EquipmentsStatus $status0
 * @property EquipmentsType $type0
 * @property EquipmentsMark $mark0
 * @property Discount $discount0
 * @property EquipmentsHistory[] $equipmentsHistories
 * @property EquipmentsHistoryChangeStatus[] $equipmentsHistoryChangeStatuses
 * @property EquipmentsInfo[] $equipmentsInfos
 */
class Equipments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'equipments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mark', 'model', 'category_id', 'stock_id', 'type', 'discount', 'status'], 'required'],
            [['mark', 'category_id', 'stock_id', 'type', 'discount', 'status'], 'integer'],
            [['date_create'], 'safe'],
            [['model', 'photo'], 'string', 'max' => 150],
            [['count', 'selling', 'selling_price', 'price_per_day', 'rentals', 'repairs', 'repairs_sum', 'tool_number', 'revenue', 'profit', 'degree_wear', 'payback_ratio', 'countHire', 'is_not_active', 'count_hire', 'count_repairs'], 'string', 'max' => 45],
            [['photo_alias'], 'string', 'max' => 250],
            [['dop_status'], 'string', 'max' => 500],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => EquipmentsCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['stock_id'], 'exist', 'skipOnError' => true, 'targetClass' => Stock::className(), 'targetAttribute' => ['stock_id' => 'id']],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => EquipmentsStatus::className(), 'targetAttribute' => ['status' => 'id']],
            [['type'], 'exist', 'skipOnError' => true, 'targetClass' => EquipmentsType::className(), 'targetAttribute' => ['type' => 'id']],
            [['mark'], 'exist', 'skipOnError' => true, 'targetClass' => EquipmentsMark::className(), 'targetAttribute' => ['mark' => 'id']],
            [['discount'], 'exist', 'skipOnError' => true, 'targetClass' => Discount::className(), 'targetAttribute' => ['discount' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mark' => 'Mark',
            'model' => 'Model',
            'category_id' => 'Category ID',
            'stock_id' => 'Stock ID',
            'type' => 'Type',
            'discount' => 'Discount',
            'status' => 'Status',
            'count' => 'Count',
            'selling' => 'Selling',
            'selling_price' => 'Selling Price',
            'price_per_day' => 'Price Per Day',
            'rentals' => 'Rentals',
            'repairs' => 'Repairs',
            'repairs_sum' => 'Repairs Sum',
            'tool_number' => 'Tool Number',
            'revenue' => 'Revenue',
            'profit' => 'Profit',
            'degree_wear' => 'Degree Wear',
            'payback_ratio' => 'Payback Ratio',
            'date_create' => 'Date Create',
            'photo' => 'Photo',
            'countHire' => 'Count Hire',
            'photo_alias' => 'Photo Alias',
            'is_not_active' => 'Is Not Active',
            'dop_status' => 'Dop Status',
            'count_hire' => 'Count Hire',
            'count_repairs' => 'Count Repairs',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationEquipments()
    {
        return $this->hasMany(ApplicationEquipment::className(), ['equipments_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(EquipmentsCategory::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStock()
    {
        return $this->hasOne(Stock::className(), ['id' => 'stock_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus0()
    {
        return $this->hasOne(EquipmentsStatus::className(), ['id' => 'status']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType0()
    {
        return $this->hasOne(EquipmentsType::className(), ['id' => 'type']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMark0()
    {
        return $this->hasOne(EquipmentsMark::className(), ['id' => 'mark']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDiscount0()
    {
        return $this->hasOne(Discount::className(), ['id' => 'discount']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEquipmentsHistories()
    {
        return $this->hasMany(EquipmentsHistory::className(), ['equipments_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEquipmentsHistoryChangeStatuses()
    {
        return $this->hasMany(EquipmentsHistoryChangeStatus::className(), ['equipments_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEquipmentsInfos()
    {
        return $this->hasMany(EquipmentsInfo::className(), ['equipments_id' => 'id']);
    }
}
