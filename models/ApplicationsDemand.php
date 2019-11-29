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
}
