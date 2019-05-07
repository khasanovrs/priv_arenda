<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $fio фио пользователя
 * @property int $telephone телефон пользователя
 * @property string $status
 * @property int $user_type
 * @property string $email
 * @property string $password пароль пользователя
 * @property string $date_create дата создания записи
 * @property string $date_update тип роли
 *
 * @property Session[] $sessions
 * @property UsersRole $userType
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fio', 'telephone', 'user_type', 'password'], 'required'],
            [['telephone', 'user_type'], 'integer'],
            [['date_create'], 'safe'],
            [['fio'], 'string', 'max' => 100],
            [['status', 'email', 'password', 'date_update'], 'string', 'max' => 45],
            [['user_type'], 'exist', 'skipOnError' => true, 'targetClass' => UsersRole::className(), 'targetAttribute' => ['user_type' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fio' => 'Fio',
            'telephone' => 'Telephone',
            'status' => 'Status',
            'user_type' => 'User Type',
            'email' => 'Email',
            'password' => 'Password',
            'date_create' => 'Date Create',
            'date_update' => 'Date Update',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSessions()
    {
        return $this->hasMany(Session::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserType()
    {
        return $this->hasOne(UsersRole::className(), ['id' => 'user_type']);
    }
}
