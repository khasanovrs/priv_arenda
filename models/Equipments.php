<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "equipments".
 *
 * @property int $id
 * @property string $name
 * @property int $category_id идентификатор категории
 * @property int $stock_id
 * @property int $type тип инструмента
 * @property int $availability Доступность
 * @property string $equipmentscol
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
 * @property int $status
 *
 * @property EquipmentsStatus $status0
 * @property EquipmentsAvailability $availability0
 * @property EquipmentsCategory $category
 * @property Stock $stock
 * @property EquipmentsType $type0
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
            [['name', 'category_id', 'stock_id', 'type', 'availability', 'status'], 'required'],
            [['category_id', 'stock_id', 'type', 'availability', 'status'], 'integer'],
            [['date_create'], 'safe'],
            [['name', 'equipmentscol', 'selling_price', 'price_per_day', 'rentals', 'repairs', 'repairs_sum', 'tool_number', 'revenue', 'profit', 'degree_wear', 'payback_ratio'], 'string', 'max' => 45],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => EquipmentsStatus::className(), 'targetAttribute' => ['status' => 'id']],
            [['availability'], 'exist', 'skipOnError' => true, 'targetClass' => EquipmentsAvailability::className(), 'targetAttribute' => ['availability' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => EquipmentsCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['stock_id'], 'exist', 'skipOnError' => true, 'targetClass' => Stock::className(), 'targetAttribute' => ['stock_id' => 'id']],
            [['type'], 'exist', 'skipOnError' => true, 'targetClass' => EquipmentsType::className(), 'targetAttribute' => ['type' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'category_id' => 'Category ID',
            'stock_id' => 'Stock ID',
            'type' => 'Type',
            'availability' => 'Availability',
            'equipmentscol' => 'Equipmentscol',
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
            'status' => 'Status',
        ];
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
    public function getAvailability0()
    {
        return $this->hasOne(EquipmentsAvailability::className(), ['id' => 'availability']);
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
    public function getType0()
    {
        return $this->hasOne(EquipmentsType::className(), ['id' => 'type']);
    }
}
