<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "equipments_show_field".
 *
 * @property int $id
 * @property int $user_id
 * @property int $equipments_field_id код поля
 *
 * @property EquipmentsField $equipmentsField
 * @property Users $user
 */
class EquipmentsShowField extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'equipments_show_field';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'equipments_field_id'], 'required'],
            [['user_id', 'equipments_field_id'], 'integer'],
            [['equipments_field_id'], 'exist', 'skipOnError' => true, 'targetClass' => EquipmentsField::className(), 'targetAttribute' => ['equipments_field_id' => 'id']],
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
            'user_id' => 'User ID',
            'equipments_field_id' => 'Equipments Field ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEquipmentsField()
    {
        return $this->hasOne(EquipmentsField::className(), ['id' => 'equipments_field_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}
