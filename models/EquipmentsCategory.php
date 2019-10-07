<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "equipments_category".
 *
 * @property int $id
 * @property string $name Наименование категории
 *
 * @property Equipments[] $equipments
 * @property EquipmentsType[] $equipmentsTypes
 */
class EquipmentsCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'equipments_category';
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
        return $this->hasMany(Equipments::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEquipmentsTypes()
    {
        return $this->hasMany(EquipmentsType::className(), ['category_id' => 'id']);
    }
}
