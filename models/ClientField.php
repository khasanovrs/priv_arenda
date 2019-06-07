<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "client_field".
 *
 * @property int $id
 * @property string $code
 * @property string $name наименование поля
 *
 * @property ClientShowField[] $clientShowFields
 */
class ClientField extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'client_field';
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
    public function getClientShowFields()
    {
        return $this->hasMany(ClientShowField::className(), ['equipments_field_id' => 'id']);
    }
}
