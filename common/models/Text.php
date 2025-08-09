<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "text".
 *
 * @property int $id
 * @property string $title1
 * @property string $title1_ru
 * @property string $title2
 * @property string $title2_ru
 * @property string $text
 * @property string $text_ru
 */
class Text extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'text';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title1', 'title1_ru', 'title1_en', 'title2', 'title2_ru', 'title2_en', 'text', 'text_ru', 'text_en'], 'required'],
            [['text', 'text_ru', 'text_en'], 'string'],
            [['title1', 'title1_ru', 'title1_en', 'title2', 'title2_ru', 'title2_en'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title1' => 'Title1',
            'title1_ru' => 'Title1 Ru',
            'title1_en' => 'Title1 En',
            'title2' => 'Title2',
            'title2_ru' => 'Title2 Ru',
            'title2_en' => 'Title2 En',
            'text' => 'Text',
            'text_ru' => 'Text Ru',
            'text_en' => 'Text En',
        ];
    }

    public function getTitle()
    {
        if(\Yii::$app->language == 'ru'){
            return $this->title1_ru;
        }
        if(\Yii::$app->language == 'uz'){
            return $this->title1;
        }
        if(\Yii::$app->language == 'en'){
            return $this->title1_en;
        }

    }

    public function getText1()
    {
        if(\Yii::$app->language == 'ru'){
            return $this->text_ru;
        }
        if(\Yii::$app->language == 'uz'){
            return $this->text;
        }
        if(\Yii::$app->language == 'en'){
            return $this->text_en;
        }

    }
}
