<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "application_sum_delivery".
 *
 * @property int $id
 * @property string $delivery_sum сумма доставки
 * @property string $delivery_sum_paid сумма оплаты доставки
 *
 * @property Applications[] $applications
 */
class ApplicationSumDelivery extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'application_sum_delivery';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['delivery_sum', 'delivery_sum_paid'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'delivery_sum' => 'Delivery Sum',
            'delivery_sum_paid' => 'Delivery Sum Paid',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplications()
    {
        return $this->hasMany(Applications::className(), ['delivery_sum_id' => 'id']);
    }
}
