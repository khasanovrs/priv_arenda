<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "session".
 *
 * @property int $id
 * @property int $user_id
 * @property string $session_date дата создания сессии
 * @property string $session_id
 * @property string $status статус сессии
 * @property string $sessioncol
 * @property string $session_date_end
 *
 * @property Users $user
 */
class Session extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'session';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id'], 'required'],
            [['id', 'user_id'], 'integer'],
            [['session_date', 'session_date_end'], 'safe'],
            [['session_id'], 'string', 'max' => 250],
            [['status', 'sessioncol'], 'string', 'max' => 45],
            [['id'], 'unique'],
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
            'session_date' => 'Session Date',
            'session_id' => 'Session ID',
            'status' => 'Status',
            'sessioncol' => 'Sessioncol',
            'session_date_end' => 'Session Date End',
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
