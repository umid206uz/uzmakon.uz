<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "photos".
 *
 * @property int $id
 * @property int $product_id
 * @property string $filename
 */
class Photos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'photos';
    }

    /**
     * {@inheritdoc}
     */
    public $photos;
    public function rules()
    {
        return [
            [['product_id', 'filename'], 'required'],
            [['product_id', 'status'], 'integer'],
            [['filename'], 'string', 'max' => 255],
            [['photos'], 'file', 'extensions' => ['jpg', 'jpeg', 'png', 'gif', 'webp'], 'skipOnEmpty' => true, 'maxFiles' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'filename' => 'Filename',
            'photos' => 'Фото 600х600, 700x700, 800x800, Max = 1000x1000',
        ];
    }
}
