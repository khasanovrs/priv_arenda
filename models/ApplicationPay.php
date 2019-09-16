<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "application_pay".
 *
 * @property int $id
 * @property int $application_equipment_id
 * @property int $user_id
 * @property string $date_create
 * @property int $cashBox
 * @property double $sum
 *
 * @property ApplicationEquipment $applicationEquipment
 * @property Users $user
 * @property FinanceCashbox $cashBox0
 */
class ApplicationPay extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'application_pay';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['application_equipment_id', 'user_id', 'sum'], 'required'],
            [['application_equipment_id', 'user_id', 'cashBox'], 'integer'],
            [['date_create'], 'safe'],
            [['sum'], 'number'],
            [['application_equipment_id'], 'exist', 'skipOnError' => true, 'targetClass' => ApplicationEquipment::className(), 'targetAttribute' => ['application_equipment_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['cashBox'], 'exist', 'skipOnError' => true, 'targetClass' => FinanceCashbox::className(), 'targetAttribute' => ['cashBox' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'application_equipment_id' => 'Application Equipment ID',
            'user_id' => 'User ID',
            'date_create' => 'Date Create',
            'cashBox' => 'Cash Box',
            'sum' => 'Sum',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationEquipment()
    {
        return $this->hasOne(ApplicationEquipment::className(), ['id' => 'application_equipment_id']);
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
    public function getCashBox0()
    {
        return $this->hasOne(FinanceCashbox::className(), ['id' => 'cashBox']);
    }
}
