<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "equipments_status".
 *
 * @property int $id
 * @property string $name
 * @property string $color
 *
 * @property Equipments[] $equipments
 * @property EquipmentsHistoryChangeStatus[] $equipmentsHistoryChangeStatuses
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
    public function getEquipments()
    {
        return $this->hasMany(Equipments::className(), ['status' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEquipmentsHistoryChangeStatuses()
    {
        return $this->hasMany(EquipmentsHistoryChangeStatus::className(), ['old_status' => 'id']);
    }
}
