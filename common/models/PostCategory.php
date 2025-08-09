<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "post_category".
 *
 * @property int $id
 * @property string $name
 * @property string $name_ru
 * @property string $name_en
 * @property int $created_date
 *
 * @property Post[] $posts
 */
class PostCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'name_ru', 'name_en', 'created_date', 'description', 'description_ru', 'description_en'], 'required'],
            [['created_date'], 'integer'],
            [['name', 'name_ru', 'name_en', 'description', 'description_ru', 'description_en'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'name_ru' => 'Name Ru',
            'name_en' => 'Name En',
	    'description' => 'Description',
            'description_ru' => 'Description Ru',
            'description_en' => 'Description En',
            'created_date' => 'Created Date',
        ];
    }

    /**
     * Gets query for [[Posts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getName1()
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

    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['category_id' => 'id']);
    }
}
