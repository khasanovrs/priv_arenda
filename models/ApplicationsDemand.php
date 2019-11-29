<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "applications_demand".
 *
 * @property int $id
 * @property int $client_id
 * @property int $user_id
 * @property int $branch_id
 * @property string $comment
 * @property string $date_create
 * @property string $is_not_active
 * @property int $eq_id
 *
 * @property EquipmentsDemand $eq
 * @property Branch $branch
 * @property Users $user
 * @property Clients $client
 */
class ApplicationsDemand extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'applications_demand';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_id', 'user_id', 'branch_id', 'eq_id'], 'integer'],
            [['user_id', 'branch_id', 'eq_id'], 'required'],
            [['date_create'], 'safe'],
            [['comment'], 'string', 'max' => 500],
            [['is_not_active'], 'string', 'max' => 45],
            [['eq_id'], 'exist', 'skipOnError' => true, 'targetClass' => EquipmentsDemand::className(), 'targetAttribute' => ['eq_id' => 'id']],
            [['branch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Branch::className(), 'targetAttribute' => ['branch_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clients::className(), 'targetAttribute' => ['client_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client_id' => 'Client ID',
            'user_id' => 'User ID',
            'branch_id' => 'Branch ID',
            'comment' => 'Comment',
            'date_create' => 'Date Create',
            'is_not_active' => 'Is Not Active',
            'eq_id' => 'Eq ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEq()
    {
        return $this->hasOne(EquipmentsDemand::className(), ['id' => 'eq_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBranch()
    {
        return $this->hasOne(Branch::className(), ['id' => 'branch_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Clients::className(), ['id' => 'client_id']);
    }
}
