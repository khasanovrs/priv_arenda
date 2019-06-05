<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "equipments_category".
 *
 * @property int $id
 * @property string $code наименование категории
 * @property string $name Наименование категории
 *
 * @property Equipments[] $equipments
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
            [['code', 'name'], 'required'],
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
        return $this->hasMany(Equipments::className(), ['category_id' => 'id']);
    }
}
