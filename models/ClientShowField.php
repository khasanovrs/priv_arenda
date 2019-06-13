<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "client_show_field".
 *
 * @property int $id
 * @property int $user_id
 * @property int $equipments_field_id код поля
 *
 * @property Users $user
 * @property ClientField $equipmentsField
 */
class ClientShowField extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'client_show_field';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'equipments_field_id'], 'required'],
            [['user_id', 'equipments_field_id'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['equipments_field_id'], 'exist', 'skipOnError' => true, 'targetClass' => ClientField::className(), 'targetAttribute' => ['equipments_field_id' => 'id']],
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
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEquipmentsField()
    {
        return $this->hasOne(ClientField::className(), ['id' => 'equipments_field_id']);
    }
}
