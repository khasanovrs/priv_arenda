<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "equipments_field".
 *
 * @property int $id
 * @property string $code
 * @property string $name наименование поля
 *
 * @property EquipmentsShowField[] $equipmentsShowFields
 */
class EquipmentsField extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'equipments_field';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
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
    public function getEquipmentsShowFields()
    {
        return $this->hasMany(EquipmentsShowField::className(), ['equipments_field_id' => 'id']);
    }
}
