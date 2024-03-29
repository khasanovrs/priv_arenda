<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "finance".
 *
 * @property int $id
 * @property string $name
 * @property int $branch_id
 * @property int $category_id
 * @property int $type_id
 * @property string $date_create
 * @property string $sum
 * @property int $cashBox_id
 * @property int $eq_id идентификатор оборудования
 *
 * @property FinanceCategory $category
 * @property FinanceType $type
 * @property FinanceCashbox $cashBox
 * @property Branch $branch
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
            [['name', 'category_id', 'type_id', 'cashBox_id'], 'required'],
            [['branch_id', 'category_id', 'type_id', 'cashBox_id', 'eq_id'], 'integer'],
            [['date_create'], 'safe'],
            [['name'], 'string', 'max' => 150],
            [['sum'], 'string', 'max' => 45],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => FinanceCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => FinanceType::className(), 'targetAttribute' => ['type_id' => 'id']],
            [['cashBox_id'], 'exist', 'skipOnError' => true, 'targetClass' => FinanceCashbox::className(), 'targetAttribute' => ['cashBox_id' => 'id']],
            [['branch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Branch::className(), 'targetAttribute' => ['branch_id' => 'id']],
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
            'branch_id' => 'Branch ID',
            'category_id' => 'Category ID',
            'type_id' => 'Type ID',
            'date_create' => 'Date Create',
            'sum' => 'Sum',
            'cashBox_id' => 'Cash Box ID',
            'eq_id' => 'Eq ID',
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
    public function getCashBox()
    {
        return $this->hasOne(FinanceCashbox::className(), ['id' => 'cashBox_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBranch()
    {
        return $this->hasOne(Branch::className(), ['id' => 'branch_id']);
    }
}
