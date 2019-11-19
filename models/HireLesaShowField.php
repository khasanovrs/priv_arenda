<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hire_lesa_show_field".
 *
 * @property int $id
 * @property int $user_id
 * @property int $hire_field_id код поля
 */
class HireLesaShowField extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hire_lesa_show_field';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'hire_field_id'], 'required'],
            [['user_id', 'hire_field_id'], 'integer'],
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
}
