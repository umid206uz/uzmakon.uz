<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "pages".
 *
 * @property int $id
 * @property string $title
 * @property string $title_ru
 * @property string $title_en
 * @property string $url
 * @property string $url_ru
 * @property string $url_en
 * @property string $meta_title
 * @property string $meta_title_ru
 * @property string $meta_title_en
 * @property string $meta_description
 * @property string $meta_description_ru
 * @property string $meta_description_en
 */
class Pages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'title_ru', 'title_en', 'url', 'url_ru', 'url_en', 'meta_title', 'meta_title_ru', 'meta_title_en', 'meta_description', 'meta_description_ru', 'meta_description_en'], 'required'],
            [['title', 'title_ru', 'title_en', 'url', 'url_ru', 'url_en', 'meta_title', 'meta_title_ru', 'meta_title_en'], 'string', 'max' => 255],
            [['meta_description', 'meta_description_ru', 'meta_description_en'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
     
    public function getMetaTitleTranslate(){
        if(\Yii::$app->language == 'ru'){
            return $this->meta_title_ru;
        }
        if(\Yii::$app->language == 'uz'){
            return $this->meta_title;
        }
        if(\Yii::$app->language == 'en'){
            return $this->meta_title_en;
        }
    }

    public function getTitle1(){
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
    
    public function getUrl1(){
        if(\Yii::$app->language == 'ru'){
            return $this->url_ru;
        }
        if(\Yii::$app->language == 'uz'){
            return $this->url;
        }
        if(\Yii::$app->language == 'en'){
            return $this->url_en;
        }
    }
    
    public function getMetaDescriptionTranslate(){
        if(\Yii::$app->language == 'ru'){
            return $this->meta_description_ru;
        }
        if(\Yii::$app->language == 'uz'){
            return $this->meta_description;
        }
        if(\Yii::$app->language == 'en'){
            return $this->meta_description_en;
        }
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t("app", "Name (in Uzbek)"),
            'title_ru' => Yii::t("app", "Name (in Russian)"),
            'title_en' => Yii::t("app", "Name (in English)"),
            'url' => Yii::t("app", "Url (in Uzbek)"),
            'url_ru' => Yii::t("app", "Url (in Russian)"),
            'url_en' => Yii::t("app", "Url (in English)"),
            'meta_description' => Yii::t("app", "Meta Description (in Uzbek)"),
            'meta_description_ru' => Yii::t("app", "Meta Description (in Russian)"),
            'meta_description_en' => Yii::t("app", "Meta Description (in English)"),
            'meta_title' => Yii::t("app", "Meta Title (in Uzbek)"),
            'meta_title_ru' => Yii::t("app", "Meta Title (in Russian)"),
            'meta_title_en' => Yii::t("app", "Meta Title (in English)"),
        ];
    }
}
