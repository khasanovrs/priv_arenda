<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "finance_show_field".
 *
 * @property int $id
 * @property int $user_id
 * @property int $finance_field_id код поля
 *
 * @property Users $user
 */
class FinanceShowField extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'finance_show_field';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'finance_field_id'], 'required'],
            [['user_id', 'finance_field_id'], 'integer'],
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
            'finance_field_id' => 'Finance Field ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}
