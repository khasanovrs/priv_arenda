<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "extension".
 *
 * @property int $id
 * @property string $date_create
 * @property string $count
 * @property int $user_id
 * @property int $application_id
 * @property string $type тип продления, 1- день, 2-месяц
 *
 * @property Applications $application
 * @property Users $user
 */
class Extension extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'extension';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date_create', 'count', 'user_id', 'application_id', 'type'], 'required'],
            [['date_create'], 'safe'],
            [['user_id', 'application_id'], 'integer'],
            [['count', 'type'], 'string', 'max' => 45],
            [['application_id'], 'exist', 'skipOnError' => true, 'targetClass' => Applications::className(), 'targetAttribute' => ['application_id' => 'id']],
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
            'date_create' => 'Date Create',
            'count' => 'Count',
            'user_id' => 'User ID',
            'application_id' => 'Application ID',
            'type' => 'Type',
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
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}
