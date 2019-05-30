<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "clients".
 *
 * @property int $id
 * @property string $name
 * @property int $type тип клиента,1-физ. лицо, 2-юр. лицо
 * @property string $phone
 * @property int $status
 * @property int $branch_id
 * @property string $last_contact последний контакт
 * @property string $date_create дата создания записи
 */
class Clients extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clients';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'phone', 'status', 'branch_id'], 'required'],
            [['type', 'status', 'branch_id'], 'integer'],
            [['last_contact', 'date_create'], 'safe'],
            [['name'], 'string', 'max' => 150],
            [['phone'], 'string', 'max' => 11],
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
            'type' => 'Type',
            'phone' => 'Phone',
            'status' => 'Status',
            'branch_id' => 'Branch ID',
            'last_contact' => 'Last Contact',
            'date_create' => 'Date Create',
        ];
    }
}
