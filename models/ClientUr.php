<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "client_ur".
 *
 * @property int $id
 * @property string $name_org
 * @property string $phone
 * @property int $status
 * @property int $branch_id
 * @property string $last_contact последний контакт
 * @property string $date_create дата создания записи
 *
 * @property ClientFiz[] $clientFizs
 * @property Branch $branch
 * @property ClientStatus $status0
 * @property ClientUrInfo[] $clientUrInfos
 */
class ClientUr extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'client_ur';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'branch_id'], 'integer'],
            [['last_contact', 'date_create'], 'safe'],
            [['name_org'], 'string', 'max' => 150],
            [['phone'], 'string', 'max' => 11],
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
            'name_org' => 'Name Org',
            'phone' => 'Phone',
            'status' => 'Status',
            'branch_id' => 'Branch ID',
            'last_contact' => 'Last Contact',
            'date_create' => 'Date Create',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientFizs()
    {
        return $this->hasMany(ClientFiz::className(), ['org_id' => 'id']);
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
    public function getClientUrInfos()
    {
        return $this->hasMany(ClientUrInfo::className(), ['client_id' => 'id']);
    }
}
