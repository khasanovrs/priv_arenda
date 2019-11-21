<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "application_pay".
 *
 * @property int $id
 * @property int $application_id
 * @property int $user_id
 * @property string $date_create
 * @property int $cashBox
 * @property double $sum
 * @property int $client_id
 *
 * @property Users $user
 * @property FinanceCashbox $cashBox0
 * @property Applications $application
 */
class ApplicationPay extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'application_pay';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['application_id', 'user_id', 'sum', 'client_id'], 'required'],
            [['application_id', 'user_id', 'cashBox', 'client_id'], 'integer'],
            [['date_create'], 'safe'],
            [['sum'], 'number'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['cashBox'], 'exist', 'skipOnError' => true, 'targetClass' => FinanceCashbox::className(), 'targetAttribute' => ['cashBox' => 'id']],
            [['application_id'], 'exist', 'skipOnError' => true, 'targetClass' => Applications::className(), 'targetAttribute' => ['application_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'application_id' => 'Application ID',
            'user_id' => 'User ID',
            'date_create' => 'Date Create',
            'cashBox' => 'Cash Box',
            'sum' => 'Sum',
            'client_id' => 'Client ID',
        ];
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
    public function getCashBox0()
    {
        return $this->hasOne(FinanceCashbox::className(), ['id' => 'cashBox']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplication()
    {
        return $this->hasOne(Applications::className(), ['id' => 'application_id']);
    }
}
