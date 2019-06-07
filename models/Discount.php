<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "discount".
 *
 * @property int $id
 * @property string $code
 * @property string $name
 *
 * @property ClientsInfo[] $clientsInfos
 */
class Discount extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'discount';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'name'], 'required'],
            [['code', 'name'], 'string', 'max' => 45],
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
    public function getClientsInfos()
    {
        return $this->hasMany(ClientsInfo::className(), ['sale' => 'id']);
    }
}
