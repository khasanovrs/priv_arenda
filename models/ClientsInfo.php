<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "clients_info".
 *
 * @property int $id
 * @property int $client_id
 * @property int $source источник
 * @property int $rentals прокаты
 * @property int $dohod доход
 * @property int $sale скидки
 * @property string $inn
 * @property string $kpp
 * @property string $name_chief
 * @property string $phone_chief
 * @property string $phone_second
 * @property string $date_birth
 * @property string $email
 * @property string $number_passport
 * @property string $date_create дата создания записи
 * @property string $date_update дата создания записи
 * @property string $bonus_account
 *
 * @property Clients $client
 * @property Source $source0
 * @property Discount $sale0
 */
class ClientsInfo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clients_info';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_id', 'source', 'rentals'], 'required'],
            [['client_id', 'source', 'rentals', 'dohod', 'sale'], 'integer'],
            [['date_create', 'date_update'], 'safe'],
            [['inn'], 'string', 'max' => 20],
            [['kpp', 'phone_second', 'bonus_account'], 'string', 'max' => 45],
            [['name_chief', 'phone_chief', 'date_birth', 'email', 'number_passport'], 'string', 'max' => 150],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clients::className(), 'targetAttribute' => ['client_id' => 'id']],
            [['source'], 'exist', 'skipOnError' => true, 'targetClass' => Source::className(), 'targetAttribute' => ['source' => 'id']],
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
            'inn' => 'Inn',
            'kpp' => 'Kpp',
            'name_chief' => 'Name Chief',
            'phone_chief' => 'Phone Chief',
            'phone_second' => 'Phone Second',
            'date_birth' => 'Date Birth',
            'email' => 'Email',
            'number_passport' => 'Number Passport',
            'date_create' => 'Date Create',
            'date_update' => 'Date Update',
            'bonus_account' => 'Bonus Account',
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
    public function getSource0()
    {
        return $this->hasOne(Source::className(), ['id' => 'source']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSale0()
    {
        return $this->hasOne(Discount::className(), ['id' => 'sale']);
    }
}
