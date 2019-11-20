<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "applications".
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
 * @property string $date_end
 * @property string $is_not_active
 * @property string $lesa Леса
 * @property string $month_sum
 * @property string $square
 * @property string $address
 *
 * @property ApplicationEquipment[] $applicationEquipments
 * @property Source $source
 * @property Discount $discount
 * @property ApplicationsDelivery $delivery
 * @property ApplicationsTypeLease $typeLease
 * @property Users $user
 * @property Branch $branch
 * @property Clients $client
 */
class Applications extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'applications';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_id', 'source_id', 'discount_id', 'delivery_id', 'type_lease_id', 'user_id', 'branch_id'], 'integer'],
            [['source_id', 'discount_id', 'delivery_id', 'type_lease_id', 'user_id', 'branch_id'], 'required'],
            [['rent_start', 'rent_end', 'date_create', 'date_end'], 'safe'],
            [['comment', 'address'], 'string', 'max' => 500],
            [['is_not_active', 'lesa', 'square'], 'string', 'max' => 45],
            [['month_sum'], 'string', 'max' => 150],
            [['source_id'], 'exist', 'skipOnError' => true, 'targetClass' => Source::className(), 'targetAttribute' => ['source_id' => 'id']],
            [['discount_id'], 'exist', 'skipOnError' => true, 'targetClass' => Discount::className(), 'targetAttribute' => ['discount_id' => 'id']],
            [['delivery_id'], 'exist', 'skipOnError' => true, 'targetClass' => ApplicationsDelivery::className(), 'targetAttribute' => ['delivery_id' => 'id']],
            [['type_lease_id'], 'exist', 'skipOnError' => true, 'targetClass' => ApplicationsTypeLease::className(), 'targetAttribute' => ['type_lease_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['branch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Branch::className(), 'targetAttribute' => ['branch_id' => 'id']],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clients::className(), 'targetAttribute' => ['client_id' => 'id']],
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
            'date_end' => 'Date End',
            'is_not_active' => 'Is Not Active',
            'lesa' => 'Lesa',
            'month_sum' => 'Month Sum',
            'square' => 'Square',
            'address' => 'Address',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationEquipments()
    {
        return $this->hasMany(ApplicationEquipment::className(), ['application_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSource()
    {
        return $this->hasOne(Source::className(), ['id' => 'source_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDiscount()
    {
        return $this->hasOne(Discount::className(), ['id' => 'discount_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDelivery()
    {
        return $this->hasOne(ApplicationsDelivery::className(), ['id' => 'delivery_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTypeLease()
    {
        return $this->hasOne(ApplicationsTypeLease::className(), ['id' => 'type_lease_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBranch()
    {
        return $this->hasOne(Branch::className(), ['id' => 'branch_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Clients::className(), ['id' => 'client_id']);
    }
}
