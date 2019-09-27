<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "client_status_change".
 *
 * @property int $id
 * @property int $client_id
 * @property int $old_status
 * @property int $new_status
 * @property int $user_id
 * @property string $text
 * @property string $date последний контакт
 *
 * @property Clients $client
 * @property ClientStatus $oldStatus
 * @property ClientStatus $newStatus
 * @property Users $user
 */
class ClientStatusChange extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'client_status_change';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_id', 'old_status', 'new_status', 'user_id', 'text'], 'required'],
            [['client_id', 'old_status', 'new_status', 'user_id'], 'integer'],
            [['date'], 'safe'],
            [['text'], 'string', 'max' => 500],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clients::className(), 'targetAttribute' => ['client_id' => 'id']],
            [['old_status'], 'exist', 'skipOnError' => true, 'targetClass' => ClientStatus::className(), 'targetAttribute' => ['old_status' => 'id']],
            [['new_status'], 'exist', 'skipOnError' => true, 'targetClass' => ClientStatus::className(), 'targetAttribute' => ['new_status' => 'id']],
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
            'client_id' => 'Client ID',
            'old_status' => 'Old Status',
            'new_status' => 'New Status',
            'user_id' => 'User ID',
            'text' => 'Text',
            'date' => 'Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Clients::className(), ['id' => 'client_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOldStatus()
    {
        return $this->hasOne(ClientStatus::className(), ['id' => 'old_status']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNewStatus()
    {
        return $this->hasOne(ClientStatus::className(), ['id' => 'new_status']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}
