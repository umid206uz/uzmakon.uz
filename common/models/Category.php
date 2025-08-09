<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $title
 * @property string $title_ru
 * @property string $title_en
 * @property string $filename
 * @property int $parent_id
 * @property int $picture
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public $picture;
    public $icon;
    public function rules()
    {
        return [
            [['title', 'title_ru', 'title_en', 'filename', 'meta_description', 'meta_description_ru', 'meta_description_en', 'meta_title', 'meta_title_ru', 'meta_title_en', 'url', 'url_ru', 'url_en'], 'required'],
            [['parent_id', 'child_id', 'status'], 'integer'],
            [['meta_description', 'meta_description_ru', 'meta_description_en'], 'string'],
            [['title', 'title_ru', 'title_en', 'filename', 'meta_title', 'meta_title_ru', 'meta_title_en', 'url', 'url_ru', 'url_en'], 'string', 'max' => 255],
            ['picture', 'file', 'extensions' => ['jpg', 'jpeg', 'png', 'gif'], 'skipOnEmpty' => true],
	    ['icon', 'file', 'extensions' => ['jpg', 'jpeg', 'png', 'gif', 'svg'], 'skipOnEmpty' => true],

        ];
    }

    /**
     * {@inheritdoc}
     */

    public function getTitleTranslate()
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

    public function getUrl1()
    {
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

    public function getMetaTitleTranslate()
    {
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

    public function getMetaDescriptionTranslate()
    {
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
            'id' => 'ID',
            'title' => Yii::t("app", "Name (in Uzbek)"),
            'title_ru' => Yii::t("app", "Name (in Russian)"),
            'title_en' => Yii::t("app", "Name (in English)"),
            'meta_description' => Yii::t("app", "Meta Description (in Uzbek)"),
            'meta_description_ru' => Yii::t("app", "Meta Description (in Russian)"),
            'meta_description_en' => Yii::t("app", "Meta Description (in English)"),
            'meta_title' => Yii::t("app", "Meta Title (in Uzbek)"),
            'meta_title_ru' => Yii::t("app", "Meta Title (in Russian)"),
            'meta_title_en' => Yii::t("app", "Meta Title (in English)"),
            'url' => Yii::t("app", "Url (in Uzbek)"),
            'url_ru' => Yii::t("app", "Url (in Russian)"),
            'url_en' => Yii::t("app", "Url (in English)"),
            'filename' => Yii::t("app", "Picture"),
            'status' => Yii::t("app", "Status"),
            'parent_id' => 'связанная категория',
            'picture' => Yii::t("app", "Picture"),
        ];
    }
}
