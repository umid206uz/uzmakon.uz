<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "regions".
 *
 * @property int $id
 * @property int $parent_id
 * @property int $code
 * @property int $price
 * @property string $name
 */
class Regions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'regions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'code', 'name'], 'required'],
            [['parent_id', 'code', 'price'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'code' => Yii::t('app', 'Code'),
            'name' => Yii::t('app', 'Name'),
        ];
    }
}
