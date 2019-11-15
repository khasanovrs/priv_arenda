<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "equipments_lesa".
 *
 * @property int $id
 * @property string $name
 * @property string $count
 * @property string $count_hire
 * @property string $count_repairs
 */
class EquipmentsLesa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'equipments_lesa';
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
            [['count', 'count_hire', 'count_repairs'], 'string', 'max' => 45],
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
            'count' => 'Count',
            'count_hire' => 'Count Hire',
            'count_repairs' => 'Count Repairs',
        ];
    }
}
