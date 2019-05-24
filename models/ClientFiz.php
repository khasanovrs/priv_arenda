<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "client_fiz".
 *
 * @property int $id
 * @property string $fio
 * @property string $phone
 * @property int $org_id
 * @property int $status
 * @property string $last_contact последний контакт
 * @property int $source источник
 * @property int $rentals прокаты
 * @property int $dohod доход
 * @property int $sale скидки
 * @property string $date_create дата создания записи
 *
 * @property ClientUr $org
 * @property ClientSource $source0
 * @property ClientStatus $status0
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
            [['fio', 'phone', 'status', 'last_contact', 'source', 'rentals', 'dohod', 'sale', 'date_create'], 'required'],
            [['org_id', 'status', 'source', 'rentals', 'dohod', 'sale'], 'integer'],
            [['last_contact', 'date_create'], 'safe'],
            [['fio'], 'string', 'max' => 150],
            [['phone'], 'string', 'max' => 11],
            [['org_id'], 'exist', 'skipOnError' => true, 'targetClass' => ClientUr::className(), 'targetAttribute' => ['org_id' => 'id']],
            [['source'], 'exist', 'skipOnError' => true, 'targetClass' => ClientSource::className(), 'targetAttribute' => ['source' => 'id']],
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
            'org_id' => 'Org ID',
            'status' => 'Status',
            'last_contact' => 'Last Contact',
            'source' => 'Source',
            'rentals' => 'Rentals',
            'dohod' => 'Dohod',
            'sale' => 'Sale',
            'date_create' => 'Date Create',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrg()
    {
        return $this->hasOne(ClientUr::className(), ['id' => 'org_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSource0()
    {
        return $this->hasOne(ClientSource::className(), ['id' => 'source']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus0()
    {
        return $this->hasOne(ClientStatus::className(), ['id' => 'status']);
    }
}
