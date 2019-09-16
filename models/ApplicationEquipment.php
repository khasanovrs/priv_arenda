<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "application_equipment".
 *
 * @property int $id
 * @property int $status_id
 * @property int $hire_status_id
 * @property int $hire_state_id
 * @property int $application_id
 * @property int $equipments_id
 * @property int $equipments_count
 * @property string $delivery_sum
 * @property string $sum
 * @property string $total_paid
 * @property string $remainder
 * @property string $hire_date
 * @property string $renewals_date
 *
 * @property Applications $application
 * @property Equipments $equipments
 * @property ApplicationsStatus $status
 * @property HireStatus $hireStatus
 * @property HireState $hireState
 * @property ApplicationPay[] $applicationPays
 */
class ApplicationEquipment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'application_equipment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status_id', 'hire_state_id', 'application_id', 'equipments_id', 'equipments_count', 'sum'], 'required'],
            [['status_id', 'hire_status_id', 'hire_state_id', 'application_id', 'equipments_id', 'equipments_count'], 'integer'],
            [['hire_date', 'renewals_date'], 'safe'],
            [['delivery_sum', 'sum', 'total_paid', 'remainder'], 'string', 'max' => 45],
            [['application_id'], 'exist', 'skipOnError' => true, 'targetClass' => Applications::className(), 'targetAttribute' => ['application_id' => 'id']],
            [['equipments_id'], 'exist', 'skipOnError' => true, 'targetClass' => Equipments::className(), 'targetAttribute' => ['equipments_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => ApplicationsStatus::className(), 'targetAttribute' => ['status_id' => 'id']],
            [['hire_status_id'], 'exist', 'skipOnError' => true, 'targetClass' => HireStatus::className(), 'targetAttribute' => ['hire_status_id' => 'id']],
            [['hire_state_id'], 'exist', 'skipOnError' => true, 'targetClass' => HireState::className(), 'targetAttribute' => ['hire_state_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status_id' => 'Status ID',
            'hire_status_id' => 'Hire Status ID',
            'hire_state_id' => 'Hire State ID',
            'application_id' => 'Application ID',
            'equipments_id' => 'Equipments ID',
            'equipments_count' => 'Equipments Count',
            'delivery_sum' => 'Delivery Sum',
            'sum' => 'Sum',
            'total_paid' => 'Total Paid',
            'remainder' => 'Remainder',
            'hire_date' => 'Hire Date',
            'renewals_date' => 'Renewals Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplication()
    {
        return $this->hasOne(Applications::className(), ['id' => 'application_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEquipments()
    {
        return $this->hasOne(Equipments::className(), ['id' => 'equipments_id']);
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
    public function getHireStatus()
    {
        return $this->hasOne(HireStatus::className(), ['id' => 'hire_status_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHireState()
    {
        return $this->hasOne(HireState::className(), ['id' => 'hire_state_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationPays()
    {
        return $this->hasMany(ApplicationPay::className(), ['application_equipment_id' => 'id']);
    }
}
