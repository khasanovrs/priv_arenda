<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bunch_user_right".
 *
 * @property int $id
 * @property int $user_id
 * @property int $right_id
 *
 * @property UsersRights $right
 * @property Users $user
 */
class BunchUserRight extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bunch_user_right';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'right_id'], 'required'],
            [['user_id', 'right_id'], 'integer'],
            [['right_id'], 'exist', 'skipOnError' => true, 'targetClass' => UsersRights::className(), 'targetAttribute' => ['right_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'right_id' => 'Right ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRight()
    {
        return $this->hasOne(UsersRights::className(), ['id' => 'right_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}
