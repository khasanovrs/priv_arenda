<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "clients".
 *
 * @property int $id
 * @property string $name
 * @property int $type тип клиента,1-физ. лицо, 2-юр. лицо
 * @property string $phone
 * @property int $status
 * @property int $branch_id
 * @property string $last_contact последний контакт
 * @property string $date_create дата создания записи
 * @property string $is_not_active 0-активный,1-не активный
 *
 * @property Applications[] $applications
 * @property ClientStatusChange[] $clientStatusChanges
 * @property Branch $branch
 * @property ClientStatus $status0
 * @property ClientsInfo[] $clientsInfos
 */
class Clients extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clients';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'phone', 'status', 'branch_id'], 'required'],
            [['type', 'status', 'branch_id'], 'integer'],
            [['last_contact', 'date_create'], 'safe'],
            [['name'], 'string', 'max' => 150],
            [['phone'], 'string', 'max' => 11],
            [['is_not_active'], 'string', 'max' => 45],
            [['branch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Branch::className(), 'targetAttribute' => ['branch_id' => 'id']],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => ClientStatus::className(), 'targetAttribute' => ['status' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'type' => 'Type',
            'phone' => 'Phone',
            'status' => 'Status',
            'branch_id' => 'Branch ID',
            'last_contact' => 'Last Contact',
            'date_create' => 'Date Create',
            'is_not_active' => 'Is Not Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplications()
    {
        return $this->hasMany(Applications::className(), ['client_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientStatusChanges()
    {
        return $this->hasMany(ClientStatusChange::className(), ['client_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBranch()
    {
        return $this->hasOne(Branch::className(), ['id' => 'branch_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus0()
    {
        return $this->hasOne(ClientStatus::className(), ['id' => 'status']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientsInfos()
    {
        return $this->hasMany(ClientsInfo::className(), ['client_id' => 'id']);
    }
}
