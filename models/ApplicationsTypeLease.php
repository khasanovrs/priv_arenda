<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "applications_type_lease".
 *
 * @property int $id
 * @property string $name
 *
 * @property Applications[] $applications
 */
class ApplicationsTypeLease extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'applications_type_lease';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 150],
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
    public function getApplications()
    {
        return $this->hasMany(Applications::className(), ['type_lease_id' => 'id']);
    }
}
