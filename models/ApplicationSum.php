<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "application_sum".
 *
 * @property int $id
 * @property int $application_id
 * @property string $sum сумма
 * @property string $sum_sale сумма со скидкой
 * @property string $total_paid оплочено за прокат
 *
 * @property Applications $application
 */
class ApplicationSum extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'application_sum';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['application_id', 'sum'], 'required'],
            [['application_id'], 'integer'],
            [['sum', 'sum_sale', 'total_paid'], 'string', 'max' => 45],
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
            'sum' => 'Sum',
            'sum_sale' => 'Sum Sale',
            'total_paid' => 'Total Paid',
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
