<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "brand".
 *
 * @property int $id
 * @property string $name
 * @property string $name_ru
 * @property string $name_en
 */
class Brand extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'brand';
    }

    /**
     * {@inheritdoc}
     */
    public $picture;

    public function rules()
    {
        return [
            [['name', 'name_ru', 'name_en'], 'required'],
            [['name', 'name_ru', 'name_en', 'filename'], 'string', 'max' => 255],
	    [['status'], 'integer'],
            ['picture', 'file', 'extensions' => ['jpg', 'jpeg', 'png', 'gif'], 'skipOnEmpty' => true],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'filename' => 'Photo',
            'name' => 'Nomi',
            'name_ru' => 'Названия',
            'name_en' => 'Title',
        ];
    }
}
