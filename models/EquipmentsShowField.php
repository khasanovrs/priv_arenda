<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "equipments_show_field".
 *
 * @property int $id
 * @property int $user_id
 * @property int $equipments_show_fieldcol
 *
 * @property Users $user
 * @property EquipmentsField $equipmentsShowFieldcol
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
            [['user_id', 'equipments_show_fieldcol'], 'required'],
            [['user_id', 'equipments_show_fieldcol'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['equipments_show_fieldcol'], 'exist', 'skipOnError' => true, 'targetClass' => EquipmentsField::className(), 'targetAttribute' => ['equipments_show_fieldcol' => 'id']],
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
            'equipments_show_fieldcol' => 'Equipments Show Fieldcol',
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
    public function getEquipmentsShowFieldcol()
    {
        return $this->hasOne(EquipmentsField::className(), ['id' => 'equipments_show_fieldcol']);
    }
}
