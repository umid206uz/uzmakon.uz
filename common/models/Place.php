<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "place".
 *
 * @property int $id
 * @property string $title
 */
class Place extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'place';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'coutry', 'coutry_ar', 'coutry_en', 'address', 'address_ar', 'address_en', 'mail', 'location', 'number_1', 'number_2'], 'required'],
          	[['status'], 'integer'],
            [['title', 'coutry', 'coutry_ar', 'coutry_en', 'mail', 'number_1', 'number_2'], 'string', 'max' => 255],
          	[['address', 'address_ar', 'address_en'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle1()
    {
        if(\Yii::$app->language == 'ru'){
            return $this->coutry_ar;
        }
        if(\Yii::$app->language == 'uz'){
            return $this->coutry;
        }
        if(\Yii::$app->language == 'en'){
            return $this->coutry_en;
        }
        
    }
    
    public function getAddres1()
    {
        if(\Yii::$app->language == 'ru'){
            return $this->address_ar;
        }
        if(\Yii::$app->language == 'uz'){
            return $this->address;
        }
        if(\Yii::$app->language == 'en'){
            return $this->address_en;
        }
        
    }
    
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'coutry' => 'country UZ',
            'coutry_ar' => 'country RU',
          	'status' => "Status",
            'coutry_en' => 'country EN',
            'address' => 'address Uz',
            'address_ar' => 'address Ru',
            'address_en' => 'address En',
            'mail' => 'mail',
            'location' => 'location',
            'number_1' => 'number_1',
            'number_2' => 'number_2',
        ];
    }
}
