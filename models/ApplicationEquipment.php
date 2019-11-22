<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "application_equipment".
 *
 * @property int $id
 * @property int $application_id
 * @property int $equipments_id
 * @property int $equipments_count
 * @property string $hire_date
 * @property string $renewals_date
 *
 * @property Applications $application
 * @property Equipments $equipments
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
            [['application_id', 'equipments_id', 'equipments_count'], 'required'],
            [['application_id', 'equipments_id', 'equipments_count'], 'integer'],
            [['hire_date', 'renewals_date'], 'safe'],
            [['application_id'], 'exist', 'skipOnError' => true, 'targetClass' => Applications::className(), 'targetAttribute' => ['application_id' => 'id']],
            [['equipments_id'], 'exist', 'skipOnError' => true, 'targetClass' => Equipments::className(), 'targetAttribute' => ['equipments_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'application_id' => 'Application ID',
            'equipments_id' => 'Equipments ID',
            'equipments_count' => 'Equipments Count',
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
}
