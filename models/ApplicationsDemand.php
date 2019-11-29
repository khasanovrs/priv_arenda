<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "applications_demand".
 *
 * @property int $id
 * @property int $client_id
 * @property int $source_id
 * @property int $discount_id
 * @property int $delivery_id
 * @property int $type_lease_id
 * @property int $user_id
 * @property int $branch_id
 * @property string $comment
 * @property string $rent_start
 * @property string $rent_end
 * @property string $date_create
 * @property string $is_not_active
 * @property int $eq_id
 * @property string $delivery_sum
 *
 * @property EquipmentsDemand $eq
 */
class ApplicationsDemand extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'applications_demand';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_id', 'source_id', 'discount_id', 'delivery_id', 'type_lease_id', 'user_id', 'branch_id', 'eq_id'], 'integer'],
            [['source_id', 'discount_id', 'delivery_id', 'type_lease_id', 'user_id', 'branch_id', 'eq_id'], 'required'],
            [['rent_start', 'rent_end', 'date_create'], 'safe'],
            [['comment'], 'string', 'max' => 500],
            [['is_not_active', 'delivery_sum'], 'string', 'max' => 45],
            [['eq_id'], 'exist', 'skipOnError' => true, 'targetClass' => EquipmentsDemand::className(), 'targetAttribute' => ['eq_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client_id' => 'Client ID',
            'source_id' => 'Source ID',
            'discount_id' => 'Discount ID',
            'delivery_id' => 'Delivery ID',
            'type_lease_id' => 'Type Lease ID',
            'user_id' => 'User ID',
            'branch_id' => 'Branch ID',
            'comment' => 'Comment',
            'rent_start' => 'Rent Start',
            'rent_end' => 'Rent End',
            'date_create' => 'Date Create',
            'is_not_active' => 'Is Not Active',
            'eq_id' => 'Eq ID',
            'delivery_sum' => 'Delivery Sum',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEq()
    {
        return $this->hasOne(EquipmentsDemand::className(), ['id' => 'eq_id']);
    }
}
