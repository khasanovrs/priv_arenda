<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "equipments_demand".
 *
 * @property int $id
 * @property string $model
 * @property string $confirmed 0- не подтвержден,1-подтвержден
 * @property int $count_demand Количество запросов
 *
 * @property ApplicationsDemand[] $applicationsDemands
 */
class EquipmentsDemand extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'equipments_demand';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['model', 'confirmed'], 'required'],
            [['count_demand'], 'integer'],
            [['model', 'confirmed'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'model' => 'Model',
            'confirmed' => 'Confirmed',
            'count_demand' => 'Count Demand',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationsDemands()
    {
        return $this->hasMany(ApplicationsDemand::className(), ['eq_id' => 'id']);
    }
}
