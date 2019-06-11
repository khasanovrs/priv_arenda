<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "equipments_mark".
 *
 * @property int $id
 * @property string $name
 *
 * @property Equipments[] $equipments
 */
class EquipmentsMark extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'equipments_mark';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
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
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEquipments()
    {
        return $this->hasMany(Equipments::className(), ['mark' => 'id']);
    }
}
