<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "client_ur_info".
 *
 * @property int $id
 * @property int $client_id
 * @property int $source источник
 * @property int $rentals прокаты
 * @property int $dohod доход
 * @property int $sale скидки
 * @property string $address
 * @property string $name_org
 * @property string $inn
 * @property string $occupation
 * @property string $ogrn
 * @property string $bic
 * @property string $kpp
 * @property string $schet
 * @property string $name_chief
 * @property string $phone_chief
 * @property string $phone_second
 * @property string $email
 * @property string $date_create дата создания записи
 * @property string $date_update дата создания записи
 *
 * @property ClientUr $client
 * @property Discount $sale0
 * @property ClientSource $source0
 */
class ClientUrInfo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'client_ur_info';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_id', 'source', 'rentals', 'dohod', 'sale'], 'integer'],
            [['date_create', 'date_update'], 'safe'],
            [['address', 'ogrn', 'bic', 'kpp', 'schet', 'phone_second'], 'string', 'max' => 45],
            [['name_org', 'occupation'], 'string', 'max' => 450],
            [['inn'], 'string', 'max' => 20],
            [['name_chief', 'phone_chief', 'email'], 'string', 'max' => 150],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => ClientUr::className(), 'targetAttribute' => ['client_id' => 'id']],
            [['sale'], 'exist', 'skipOnError' => true, 'targetClass' => Discount::className(), 'targetAttribute' => ['sale' => 'id']],
            [['source'], 'exist', 'skipOnError' => true, 'targetClass' => ClientSource::className(), 'targetAttribute' => ['source' => 'id']],
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
            'address' => 'Address',
            'name_org' => 'Name Org',
            'inn' => 'Inn',
            'occupation' => 'Occupation',
            'ogrn' => 'Ogrn',
            'bic' => 'Bic',
            'kpp' => 'Kpp',
            'schet' => 'Schet',
            'name_chief' => 'Name Chief',
            'phone_chief' => 'Phone Chief',
            'phone_second' => 'Phone Second',
            'email' => 'Email',
            'date_create' => 'Date Create',
            'date_update' => 'Date Update',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(ClientUr::className(), ['id' => 'client_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSale0()
    {
        return $this->hasOne(Discount::className(), ['id' => 'sale']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSource0()
    {
        return $this->hasOne(ClientSource::className(), ['id' => 'source']);
    }
}
