<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "gallery".
 *
 * @property int $id
 * @property string $filename
 * @property int $status
 */
class Gallery extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gallery';
    }

    /**
     * {@inheritdoc}
     */
    public $photos;
    public function rules()
    {
        return [
            [['filename', 'status'], 'required'],
            [['status'], 'integer'],
            [['filename', 'url'], 'string', 'max' => 255],
            [['photos'], 'file', 'extensions' => ['jpg', 'jpeg', 'png', 'gif'], 'skipOnEmpty' => true],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'filename' => 'Filename',
            'status' => 'Status',
            'photos' => 'Photos',
        ];
    }
}
