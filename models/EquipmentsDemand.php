<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "equipments_demand".
 *
 * @property int $id
 * @property string $model
 * @property int $stock_id
 * @property int $count_demand Количество запросов
 *
 * @property Stock $stock
 */
class EquipmentsDemand extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'equipments_demand';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['model', 'stock_id'], 'required'],
            [['stock_id', 'count_demand'], 'integer'],
            [['model'], 'string', 'max' => 150],
            [['stock_id'], 'exist', 'skipOnError' => true, 'targetClass' => Stock::className(), 'targetAttribute' => ['stock_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'model' => 'Model',
            'stock_id' => 'Stock ID',
            'count_demand' => 'Count Demand',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStock()
    {
        return $this->hasOne(Stock::className(), ['id' => 'stock_id']);
    }
}
