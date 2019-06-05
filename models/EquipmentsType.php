<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "equipments_type".
 *
 * @property int $id
 * @property string $code
 * @property string $name
 *
 * @property Equipments[] $equipments
 */
class EquipmentsType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'equipments_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code'], 'string', 'max' => 45],
            [['name'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEquipments()
    {
        return $this->hasMany(Equipments::className(), ['type' => 'id']);
    }
}
