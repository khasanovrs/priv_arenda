<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "show_field_client".
 *
 * @property int $id
 * @property string $code код поля
 * @property string $name наименование поля
 * @property string $flag флаг отображения, 0-нет,1-да
 */
class ShowFieldClient extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'show_field_client';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'name', 'flag'], 'required'],
            [['code', 'name'], 'string', 'max' => 150],
            [['flag'], 'string', 'max' => 5],
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
            'flag' => 'Flag',
        ];
    }
}
