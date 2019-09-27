<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "client_status".
 *
 * @property int $id
 * @property string $name
 * @property string $color
 *
 * @property ClientStatusChange[] $clientStatusChanges
 * @property ClientStatusChange[] $clientStatusChanges0
 * @property Clients[] $clients
 */
class ClientStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'client_status';
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
    public function getClientStatusChanges()
    {
        return $this->hasMany(ClientStatusChange::className(), ['old_status' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientStatusChanges0()
    {
        return $this->hasMany(ClientStatusChange::className(), ['new_status' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClients()
    {
        return $this->hasMany(Clients::className(), ['status' => 'id']);
    }
}
