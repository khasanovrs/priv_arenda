<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hire_show_field".
 *
 * @property int $id
 * @property int $user_id
 * @property int $hire_field_id код поля
 *
 * @property HireField $hireField
 * @property Users $user
 */
class HireShowField extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hire_show_field';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'hire_field_id'], 'required'],
            [['user_id', 'hire_field_id'], 'integer'],
            [['hire_field_id'], 'exist', 'skipOnError' => true, 'targetClass' => HireField::className(), 'targetAttribute' => ['hire_field_id' => 'id']],
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
            'hire_field_id' => 'Hire Field ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHireField()
    {
        return $this->hasOne(HireField::className(), ['id' => 'hire_field_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}
