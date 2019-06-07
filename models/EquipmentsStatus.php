<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "equipments_status".
 *
 * @property int $id
 * @property string $name
 *
 * @property Equipments[] $equipments
 * @property Equipments[] $equipments0
 */
class EquipmentsStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'equipments_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name'], 'required'],
            [['id'], 'integer'],
            [['name'], 'string', 'max' => 150],
            [['id'], 'unique'],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEquipments()
    {
        return $this->hasMany(Equipments::className(), ['status' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEquipments0()
    {
        return $this->hasMany(Equipments::className(), ['status' => 'id']);
    }
}
