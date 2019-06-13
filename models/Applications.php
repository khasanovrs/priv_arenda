<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "applications".
 *
 * @property int $id
 * @property int $client_id
 * @property int $status_id
 * @property int $source_id
 * @property int $discount_id
 * @property int $delivery_id
 * @property int $type_lease_id
 * @property string $comment
 * @property string $rent_start
 * @property string $rent_end
 * @property int $delivery_sum
 * @property int $total_sum
 *
 * @property ApplicationEquipment[] $applicationEquipments
 * @property Clients $client
 * @property ApplicationsSource $source
 * @property ApplicationsStatus $status
 * @property Discount $discount
 * @property ApplicationsDelivery $delivery
 * @property ApplicationsTypeLease $typeLease
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
            [['client_id', 'status_id', 'source_id', 'discount_id', 'delivery_id', 'type_lease_id'], 'required'],
            [['client_id', 'status_id', 'source_id', 'discount_id', 'delivery_id', 'type_lease_id', 'delivery_sum', 'total_sum'], 'integer'],
            [['rent_start', 'rent_end'], 'safe'],
            [['comment'], 'string', 'max' => 500],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clients::className(), 'targetAttribute' => ['client_id' => 'id']],
            [['source_id'], 'exist', 'skipOnError' => true, 'targetClass' => ApplicationsSource::className(), 'targetAttribute' => ['source_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => ApplicationsStatus::className(), 'targetAttribute' => ['status_id' => 'id']],
            [['discount_id'], 'exist', 'skipOnError' => true, 'targetClass' => Discount::className(), 'targetAttribute' => ['discount_id' => 'id']],
            [['delivery_id'], 'exist', 'skipOnError' => true, 'targetClass' => ApplicationsDelivery::className(), 'targetAttribute' => ['delivery_id' => 'id']],
            [['type_lease_id'], 'exist', 'skipOnError' => true, 'targetClass' => ApplicationsTypeLease::className(), 'targetAttribute' => ['type_lease_id' => 'id']],
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
            'status_id' => 'Status ID',
            'source_id' => 'Source ID',
            'discount_id' => 'Discount ID',
            'delivery_id' => 'Delivery ID',
            'type_lease_id' => 'Type Lease ID',
            'comment' => 'Comment',
            'rent_start' => 'Rent Start',
            'rent_end' => 'Rent End',
            'delivery_sum' => 'Delivery Sum',
            'total_sum' => 'Total Sum',
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
    public function getClient()
    {
        return $this->hasOne(Clients::className(), ['id' => 'client_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSource()
    {
        return $this->hasOne(ApplicationsSource::className(), ['id' => 'source_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(ApplicationsStatus::className(), ['id' => 'status_id']);
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
}
