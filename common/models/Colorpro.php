<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "colorpro".
 *
 * @property int $id
 * @property int $color_id
 * @property int $product_id
 *
 * @property Color $color
 * @property Product $product
 */
class Colorpro extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'colorpro';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['color_id', 'product_id'], 'required'],
            [['color_id', 'product_id'], 'integer'],
            [['color_id'], 'exist', 'skipOnError' => true, 'targetClass' => Color::className(), 'targetAttribute' => ['color_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'color_id' => 'Color ID',
            'product_id' => 'Product ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getColor()
    {
        return $this->hasOne(Color::className(), ['id' => 'color_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}
