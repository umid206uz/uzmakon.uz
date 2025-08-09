<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "slider".
 *
 * @property int $id
 * @property string $title
 * @property string $title_ru
 * @property string $title_en
 * @property string $description
 * @property string $description_ru
 * @property string $description_en
 * @property string $button
 * @property string $button_ru
 * @property string $button_en
 * @property string $filename
 * @property string $url
 * @property string $default
 */
class Slider extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'slider';
    }

    /**
     * {@inheritdoc}
     */
    public $picture;
    public function rules()
    {
        return [
            [['title', 'title_ru', 'title_en', 'description', 'description_ru', 'description_en', 'button', 'button_ru', 'button_en', 'filename', 'url', 'status'], 'required'],
            [['title', 'title_ru', 'title_en', 'description', 'description_ru', 'description_en', 'button', 'button_ru', 'button_en', 'filename', 'url'], 'string', 'max' => 255],
            [['status', 'default'], 'integer'],
            ['picture', 'file', 'extensions' => ['jpg', 'jpeg', 'png', 'gif'], 'skipOnEmpty' => true],
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

    public function getButtonTranslate()
    {
        if(\Yii::$app->language == 'ru'){
            return $this->button_ru;
        }
        if(\Yii::$app->language == 'uz'){
            return $this->button;
        }
        if(\Yii::$app->language == 'en'){
            return $this->button_en;
        }
        
    }

    public function getDescriptionTranslate()
    {
        if(\Yii::$app->language == 'ru'){
            return $this->description_ru;
        }
        if(\Yii::$app->language == 'uz'){
            return $this->description;
        }
        if(\Yii::$app->language == 'en'){
            return $this->description_en;
        }
        
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'title_ru' => Yii::t('app', 'Title Ru'),
            'title_en' => Yii::t('app', 'Title En'),
            'description' => Yii::t('app', 'Description'),
            'description_ru' => Yii::t('app', 'Description Ru'),
            'description_en' => Yii::t('app', 'Description En'),
            'button' => Yii::t('app', 'Button'),
            'button_ru' => Yii::t('app', 'Button Ru'),
            'button_en' => Yii::t('app', 'Button En'),
            'filename' => Yii::t('app', 'Filename'),
            'url' => Yii::t('app', 'Url'),
            'picture' => Yii::t('app', 'picture 1920x1080'),
        ];
    }
}
