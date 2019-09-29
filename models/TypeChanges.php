<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "type_changes".
 *
 * @property int $id
 * @property string $name
 *
 * @property EquipmentsHistory[] $equipmentsHistories
 */
class TypeChanges extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'type_changes';
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
    public function getEquipmentsHistories()
    {
        return $this->hasMany(EquipmentsHistory::className(), ['type_change' => 'id']);
    }
}
