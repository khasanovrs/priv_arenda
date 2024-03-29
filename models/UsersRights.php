<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users_rights".
 *
 * @property int $id
 * @property string $name
 *
 * @property BunchUserRight[] $bunchUserRights
 */
class UsersRights extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users_rights';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 55],
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
    public function getBunchUserRights()
    {
        return $this->hasMany(BunchUserRight::className(), ['right_id' => 'id']);
    }
}
