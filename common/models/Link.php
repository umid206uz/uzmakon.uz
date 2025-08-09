<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "link".
 *
 * @property int $id
 * @property string $title
 * @property string $title_ru
 * @property string $title_en
 * @property string $url
 */
class Link extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'link';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'title_ru', 'title_en', 'url'], 'required'],
            [['status'], 'integer'],
            [['title', 'title_ru', 'title_en', 'url'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
     
     public function getTitle1()
    {
        if(\Yii::$app->language == 'ru'){
            return $this->title_ru;
        }
        if(\Yii::$app->language == 'uz'){
            return $this->title;
        }
        if(\Yii::$app->language == 'en'){
            return $this->title_en;
        }
        
    }
    
    public function getStatus1()
    {
        if($this->status == 1){
            return "Покупателю";
        }
        if($this->status == 2){
            return "О нас";
        }
        if($this->status == 3){
            return "Наши возможности";
        }
        
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Sarlavha'),
            'title_ru' => Yii::t('app', 'Заголовок Ru'),
            'title_en' => Yii::t('app', 'Title En'),
            'url' => Yii::t('app', 'Url'),
        ];
    }
}
