<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "applications_show_field".
 *
 * @property int $id
 * @property int $user_id
 * @property int $applications_field_id код поля
 *
 * @property Users $user
 * @property ApplicationsField $applicationsField
 */
class ApplicationsShowField extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'applications_show_field';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'applications_field_id'], 'required'],
            [['user_id', 'applications_field_id'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['applications_field_id'], 'exist', 'skipOnError' => true, 'targetClass' => ApplicationsField::className(), 'targetAttribute' => ['applications_field_id' => 'id']],
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
            'applications_field_id' => 'Applications Field ID',
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
    public function getApplicationsField()
    {
        return $this->hasOne(ApplicationsField::className(), ['id' => 'applications_field_id']);
    }
}
