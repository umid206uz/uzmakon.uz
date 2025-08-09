<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "blog".
 *
 * @property int $id
 * @property string $text
 * @property string $text_ru
 * @property string $text_en
 */
class Blog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'blog';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text', 'text_ru', 'text_en'], 'required'],
            [['text', 'text_ru', 'text_en'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'text' => 'Text',
            'text_ru' => 'Text Ru',
            'text_en' => 'Text En',
        ];
    }
}
