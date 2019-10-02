<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "equipments_history_change_status".
 *
 * @property int $id
 * @property int $equipments_id
 * @property int $old_status старое значение
 * @property int $new_status новое значение
 * @property string $reason Причина изменения
 * @property string $date_create
 * @property int $user_id
 * @property string $sum
 * @property int $cashBox_id
 *
 * @property Equipments $equipments
 * @property EquipmentsStatus $oldStatus
 * @property Equipments $newStatus
 * @property Users $user
 */
class EquipmentsHistoryChangeStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'equipments_history_change_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['equipments_id', 'old_status', 'new_status', 'reason', 'user_id'], 'required'],
            [['equipments_id', 'old_status', 'new_status', 'user_id', 'cashBox_id'], 'integer'],
            [['date_create'], 'safe'],
            [['reason'], 'string', 'max' => 450],
            [['sum'], 'string', 'max' => 45],
            [['equipments_id'], 'exist', 'skipOnError' => true, 'targetClass' => Equipments::className(), 'targetAttribute' => ['equipments_id' => 'id']],
            [['old_status'], 'exist', 'skipOnError' => true, 'targetClass' => EquipmentsStatus::className(), 'targetAttribute' => ['old_status' => 'id']],
            [['new_status'], 'exist', 'skipOnError' => true, 'targetClass' => Equipments::className(), 'targetAttribute' => ['new_status' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'equipments_id' => 'Equipments ID',
            'old_status' => 'Old Status',
            'new_status' => 'New Status',
            'reason' => 'Reason',
            'date_create' => 'Date Create',
            'user_id' => 'User ID',
            'sum' => 'Sum',
            'cashBox_id' => 'Cash Box ID',
        ];
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
    public function getOldStatus()
    {
        return $this->hasOne(EquipmentsStatus::className(), ['id' => 'old_status']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNewStatus()
    {
        return $this->hasOne(Equipments::className(), ['id' => 'new_status']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}
