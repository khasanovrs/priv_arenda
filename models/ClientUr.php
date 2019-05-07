<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "client_ur".
 *
 * @property int $id
 * @property string $name_org
 * @property int $phone
 * @property int $status
 * @property string $last_contact последний контакт
 * @property int $source источник
 * @property int $rentals прокаты
 * @property int $dohod доход
 * @property int $sale скидки
 * @property string $date_create дата создания записи
 *
 * @property ClientSource $source0
 * @property ClientStatus $status0
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
            [['phone', 'status', 'source', 'rentals', 'dohod', 'sale'], 'integer'],
            [['last_contact', 'date_create'], 'safe'],
            [['name_org'], 'string', 'max' => 150],
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
            'name_org' => 'Name Org',
            'phone' => 'Phone',
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
