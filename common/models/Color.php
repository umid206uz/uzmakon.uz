<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "color".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 *
 * @property Colorpro[] $colorpros
 */
class Color extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'color';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'name_ru', 'name_en', 'code'], 'required'],
            [['name', 'name_ru', 'name_en', 'code'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Nomi',
            'name_ru' => 'Названия',
            'name_en' => 'Title',
            'code' => 'Code',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTitle1()
    {
        if(\Yii::$app->language == 'ru'){
            return $this->name_ru;
        }
        if(\Yii::$app->language == 'uz'){
            return $this->name;
        }
        if(\Yii::$app->language == 'en'){
            return $this->name_en;
        }
        
    }
    
    public function getColorpros()
    {
        return $this->hasMany(Colorpro::className(), ['color_id' => 'id']);
    }
}
