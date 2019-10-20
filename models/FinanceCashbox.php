<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "finance_cashbox".
 *
 * @property int $id
 * @property string $name Наименование категории
 * @property string $sum
 * @property string $check_zalog Залог касса. 0-нет,1-да
 * @property string $delivery
 *
 * @property ApplicationPay[] $applicationPays
 * @property Finance[] $finances
 */
class FinanceCashbox extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'finance_cashbox';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'delivery'], 'required'],
            [['name'], 'string', 'max' => 150],
            [['sum', 'check_zalog', 'delivery'], 'string', 'max' => 45],
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
            'sum' => 'Sum',
            'check_zalog' => 'Check Zalog',
            'delivery' => 'Delivery',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationPays()
    {
        return $this->hasMany(ApplicationPay::className(), ['cashBox' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinances()
    {
        return $this->hasMany(Finance::className(), ['cashBox_id' => 'id']);
    }
}
