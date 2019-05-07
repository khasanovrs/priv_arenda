<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "client_source".
 *
 * @property int $id
 * @property string $name
 *
 * @property ClientUr[] $clientUrs
 */
class ClientSource extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'client_source';
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
    public function getClientUrs()
    {
        return $this->hasMany(ClientUr::className(), ['source' => 'id']);
    }
}
