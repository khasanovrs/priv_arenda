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
 * @property string $password пароль пользователя
 * @property string $date_create дата создания записи
 * @property string $date_update статус пользователя, 0-активен,1-заблокирован
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
            [['fio', 'telephone', 'password'], 'required'],
            [['telephone'], 'integer'],
            [['date_create'], 'safe'],
            [['fio'], 'string', 'max' => 100],
            [['status', 'password', 'date_update'], 'string', 'max' => 45],
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
            'password' => 'Password',
            'date_create' => 'Date Create',
            'date_update' => 'Date Update',
        ];
    }
}
