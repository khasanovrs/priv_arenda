<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "equipments_info".
 *
 * @property int $id
 * @property int $equipments_id
 * @property string $power_energy ЭНЕРГИЯ УДАРА
 * @property string $length ГАБАРИТНАЯ ДЛИНА
 * @property string $network_cord СЕТЕВОЙ ШНУР
 * @property string $power мощность
 * @property string $frequency_hits ЧАСТОТА УДАРОВ
 *
 * @property Equipments $equipments
 */
class EquipmentsInfo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'equipments_info';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['equipments_id'], 'required'],
            [['equipments_id'], 'integer'],
            [['power_energy', 'length', 'network_cord', 'power', 'frequency_hits'], 'string', 'max' => 150],
            [['equipments_id'], 'exist', 'skipOnError' => true, 'targetClass' => Equipments::className(), 'targetAttribute' => ['equipments_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'equipments_id' => 'Equipments ID',
            'power_energy' => 'Power Energy',
            'length' => 'Length',
            'network_cord' => 'Network Cord',
            'power' => 'Power',
            'frequency_hits' => 'Frequency Hits',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEquipments()
    {
        return $this->hasOne(Equipments::className(), ['id' => 'equipments_id']);
    }
}
