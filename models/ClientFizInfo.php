<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "client_fiz_info".
 *
 * @property int $id
 * @property int $client_id
 * @property int $source источник
 * @property int $rentals прокаты
 * @property int $dohod доход
 * @property int $sale скидки
 * @property string $phone_chief
 * @property string $phone_second
 * @property string $date_create дата создания записи
 * @property string $date_update дата создания записи
 *
 * @property ClientFiz $client
 * @property ClientSource $source0
 * @property Discount $sale0
 */
class ClientFizInfo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'client_fiz_info';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_id', 'source', 'rentals', 'dohod', 'sale'], 'integer'],
            [['date_create', 'date_update'], 'safe'],
            [['phone_chief'], 'string', 'max' => 150],
            [['phone_second'], 'string', 'max' => 45],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => ClientFiz::className(), 'targetAttribute' => ['client_id' => 'id']],
            [['source'], 'exist', 'skipOnError' => true, 'targetClass' => ClientSource::className(), 'targetAttribute' => ['source' => 'id']],
            [['sale'], 'exist', 'skipOnError' => true, 'targetClass' => Discount::className(), 'targetAttribute' => ['sale' => 'id']],
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
            'source' => 'Source',
            'rentals' => 'Rentals',
            'dohod' => 'Dohod',
            'sale' => 'Sale',
            'phone_chief' => 'Phone Chief',
            'phone_second' => 'Phone Second',
            'date_create' => 'Date Create',
            'date_update' => 'Date Update',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(ClientFiz::className(), ['id' => 'client_id']);
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
    public function getSale0()
    {
        return $this->hasOne(Discount::className(), ['id' => 'sale']);
    }
}
