<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "applications_field".
 *
 * @property int $id
 * @property string $code
 * @property string $name наименование поля
 *
 * @property ApplicationsShowField[] $applicationsShowFields
 */
class ApplicationsField extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'applications_field';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['code'], 'string', 'max' => 45],
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
            'code' => 'Code',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationsShowFields()
    {
        return $this->hasMany(ApplicationsShowField::className(), ['applications_field_id' => 'id']);
    }
}
