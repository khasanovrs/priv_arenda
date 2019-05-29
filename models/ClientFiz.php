<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "client_fiz".
 *
 * @property int $id
 * @property string $fio
 * @property string $phone
 * @property int $status
 * @property int $branch_id
 * @property string $last_contact последний контакт
 * @property string $date_create дата создания записи
 *
 * @property Branch $branch
 * @property ClientStatus $status0
 * @property ClientFizInfo[] $clientFizInfos
 */
class ClientFiz extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'client_fiz';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fio', 'phone', 'status', 'last_contact', 'date_create'], 'required'],
            [['status', 'branch_id'], 'integer'],
            [['last_contact', 'date_create'], 'safe'],
            [['fio'], 'string', 'max' => 150],
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
            'fio' => 'Fio',
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
    public function getClientFizInfos()
    {
        return $this->hasMany(ClientFizInfo::className(), ['client_id' => 'id']);
    }
}
