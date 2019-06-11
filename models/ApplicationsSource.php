<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "applications_source".
 *
 * @property int $id
 * @property string $name
 *
 * @property Applications[] $applications
 */
class ApplicationsSource extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'applications_source';
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
        return $this->hasMany(Applications::className(), ['source_id' => 'id']);
    }
}
