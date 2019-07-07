<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "finance_category".
 *
 * @property int $id
 * @property string $name Наименование категории
 *
 * @property Finance[] $finances
 */
class FinanceCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'finance_category';
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
    public function getFinances()
    {
        return $this->hasMany(Finance::className(), ['category_id' => 'id']);
    }
}
