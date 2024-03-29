<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $fio фио пользователя
 * @property string $telephone телефон пользователя
 * @property string $status
 * @property int $user_type
 * @property string $email
 * @property int $branch_id филиал
 * @property string $password пароль пользователя
 * @property string $date_create дата создания записи
 * @property string $date_update Время последнего запроса sms-кода
 *
 * @property ApplicationPay[] $applicationPays
 * @property Applications[] $applications
 * @property ApplicationsDemand[] $applicationsDemands
 * @property ApplicationsShowField[] $applicationsShowFields
 * @property BunchUserRight[] $bunchUserRights
 * @property ClientShowField[] $clientShowFields
 * @property ClientStatusChange[] $clientStatusChanges
 * @property EquipmentsHistory[] $equipmentsHistories
 * @property EquipmentsHistoryChangeStatus[] $equipmentsHistoryChangeStatuses
 * @property EquipmentsShowField[] $equipmentsShowFields
 * @property Extension[] $extensions
 * @property FinanceShowField[] $financeShowFields
 * @property HireShowField[] $hireShowFields
 * @property Session[] $sessions
 * @property UsersRole $userType
 * @property Branch $branch
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
            [['fio', 'telephone', 'user_type', 'branch_id', 'password'], 'required'],
            [['user_type', 'branch_id'], 'integer'],
            [['date_create'], 'safe'],
            [['fio'], 'string', 'max' => 100],
            [['telephone'], 'string', 'max' => 11],
            [['status', 'email', 'date_update'], 'string', 'max' => 45],
            [['password'], 'string', 'max' => 500],
            [['user_type'], 'exist', 'skipOnError' => true, 'targetClass' => UsersRole::className(), 'targetAttribute' => ['user_type' => 'id']],
            [['branch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Branch::className(), 'targetAttribute' => ['branch_id' => 'id']],
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
            'branch_id' => 'Branch ID',
            'password' => 'Password',
            'date_create' => 'Date Create',
            'date_update' => 'Date Update',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationPays()
    {
        return $this->hasMany(ApplicationPay::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplications()
    {
        return $this->hasMany(Applications::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationsDemands()
    {
        return $this->hasMany(ApplicationsDemand::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationsShowFields()
    {
        return $this->hasMany(ApplicationsShowField::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBunchUserRights()
    {
        return $this->hasMany(BunchUserRight::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientShowFields()
    {
        return $this->hasMany(ClientShowField::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientStatusChanges()
    {
        return $this->hasMany(ClientStatusChange::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEquipmentsHistories()
    {
        return $this->hasMany(EquipmentsHistory::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEquipmentsHistoryChangeStatuses()
    {
        return $this->hasMany(EquipmentsHistoryChangeStatus::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEquipmentsShowFields()
    {
        return $this->hasMany(EquipmentsShowField::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExtensions()
    {
        return $this->hasMany(Extension::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinanceShowFields()
    {
        return $this->hasMany(FinanceShowField::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHireShowFields()
    {
        return $this->hasMany(HireShowField::className(), ['user_id' => 'id']);
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBranch()
    {
        return $this->hasOne(Branch::className(), ['id' => 'branch_id']);
    }
}
