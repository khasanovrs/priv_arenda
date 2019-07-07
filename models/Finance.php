<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "finance".
 *
 * @property int $id
 * @property string $name
 * @property int $category_id
 * @property int $type_id
 * @property string $date_create
 * @property int $payer_id
 * @property string $sum
 * @property int $cashBox_id
 *
 * @property FinanceCategory $category
 * @property FinanceType $type
 * @property Clients $payer
 * @property FinanceCashbox $cashBox
 */
class Finance extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'finance';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'category_id', 'type_id', 'payer_id', 'cashBox_id'], 'required'],
            [['category_id', 'type_id', 'payer_id', 'cashBox_id'], 'integer'],
            [['date_create'], 'safe'],
            [['name'], 'string', 'max' => 150],
            [['sum'], 'string', 'max' => 45],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => FinanceCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => FinanceType::className(), 'targetAttribute' => ['type_id' => 'id']],
            [['payer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clients::className(), 'targetAttribute' => ['payer_id' => 'id']],
            [['cashBox_id'], 'exist', 'skipOnError' => true, 'targetClass' => FinanceCashbox::className(), 'targetAttribute' => ['cashBox_id' => 'id']],
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
            'type_id' => 'Type ID',
            'date_create' => 'Date Create',
            'payer_id' => 'Payer ID',
            'sum' => 'Sum',
            'cashBox_id' => 'Cash Box ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(FinanceCategory::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(FinanceType::className(), ['id' => 'type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPayer()
    {
        return $this->hasOne(Clients::className(), ['id' => 'payer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCashBox()
    {
        return $this->hasOne(FinanceCashbox::className(), ['id' => 'cashBox_id']);
    }
}
