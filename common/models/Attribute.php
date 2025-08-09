<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "attribute".
 *
 * @property int $id
 * @property int $parent_id
 * @property string $name
 *
 * @property Atrcat[] $atrcats
 */
class Attribute extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'attribute';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id'], 'integer'],
            [['name', 'name_ru', 'name_en'], 'required'],
            [['name', 'name_ru', 'name_en'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'name' => 'Nomi',
            'name_en' => 'Title',
            'name_ru' => 'Названия',
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
    
    public function getAtrcats()
    {
        return $this->hasMany(Atrcat::className(), ['attribute_id' => 'id']);
    }
}
