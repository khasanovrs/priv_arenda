<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hire_status".
 *
 * @property int $id
 * @property string $name
 * @property string $color
 *
 * @property ApplicationEquipment[] $applicationEquipments
 * @property ApplicationEquipment[] $applicationEquipments0
 */
class HireStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hire_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 150],
            [['color'], 'string', 'max' => 45],
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
            'color' => 'Color',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationEquipments()
    {
        return $this->hasMany(ApplicationEquipment::className(), ['hire_status_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationEquipments0()
    {
        return $this->hasMany(ApplicationEquipment::className(), ['hire_status_id' => 'id']);
    }
}
