<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "equipments_history".
 *
 * @property int $id
 * @property int $equipments_id
 * @property int $type_change тип изменения,
 * @property string $old_params старое значение
 * @property string $new_params новое значение
 * @property string $reason Причина изменения
 * @property string $date_create
 * @property int $user_id
 *
 * @property Equipments $equipments
 * @property TypeChanges $typeChange
 * @property Users $user
 */
class EquipmentsHistory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'equipments_history';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['equipments_id', 'type_change', 'user_id'], 'required'],
            [['equipments_id', 'type_change', 'user_id'], 'integer'],
            [['date_create'], 'safe'],
            [['old_params', 'new_params'], 'string', 'max' => 45],
            [['reason'], 'string', 'max' => 450],
            [['equipments_id'], 'exist', 'skipOnError' => true, 'targetClass' => Equipments::className(), 'targetAttribute' => ['equipments_id' => 'id']],
            [['type_change'], 'exist', 'skipOnError' => true, 'targetClass' => TypeChanges::className(), 'targetAttribute' => ['type_change' => 'id']],
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
            'type_change' => 'Type Change',
            'old_params' => 'Old Params',
            'new_params' => 'New Params',
            'reason' => 'Reason',
            'date_create' => 'Date Create',
            'user_id' => 'User ID',
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
    public function getTypeChange()
    {
        return $this->hasOne(TypeChanges::className(), ['id' => 'type_change']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}
