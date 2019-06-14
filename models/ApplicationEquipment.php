<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "application_equipment".
 *
 * @property int $id
 * @property int $status_id
 * @property int $application_id
 * @property int $equipments_id
 * @property int $equipments_count
 *
 * @property Applications $application
 * @property Equipments $equipments
 * @property ApplicationsStatus $status
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
            [['status_id', 'application_id', 'equipments_id', 'equipments_count'], 'required'],
            [['status_id', 'application_id', 'equipments_id', 'equipments_count'], 'integer'],
            [['application_id'], 'exist', 'skipOnError' => true, 'targetClass' => Applications::className(), 'targetAttribute' => ['application_id' => 'id']],
            [['equipments_id'], 'exist', 'skipOnError' => true, 'targetClass' => Equipments::className(), 'targetAttribute' => ['equipments_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => ApplicationsStatus::className(), 'targetAttribute' => ['status_id' => 'id']],
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
            'application_id' => 'Application ID',
            'equipments_id' => 'Equipments ID',
            'equipments_count' => 'Equipments Count',
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
}
