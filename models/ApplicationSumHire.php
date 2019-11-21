<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "application_sum_hire".
 *
 * @property int $id
 * @property int $application_id
 * @property string $delivery_sum сумма доставки
 * @property string $delivery_sum_paid сумма оплаты доставки
 *
 * @property Applications $application
 */
class ApplicationSumHire extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'application_sum_hire';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['application_id'], 'required'],
            [['application_id'], 'integer'],
            [['delivery_sum', 'delivery_sum_paid'], 'string', 'max' => 45],
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
            'delivery_sum' => 'Delivery Sum',
            'delivery_sum_paid' => 'Delivery Sum Paid',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplication()
    {
        return $this->hasOne(Applications::className(), ['id' => 'application_id']);
    }
}
