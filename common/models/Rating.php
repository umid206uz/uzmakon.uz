<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "rating".
 *
 * @property int $id
 * @property int $product_id
 * @property int $rating
 * @property string $username
 * @property string $comment
 *
 * @property Product $product
 */
class Rating extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rating';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'rating', 'username', 'comment'], 'required'],
            [['product_id', 'rating'], 'integer'],
            [['username'], 'string', 'max' => 255],
            [['comment'], 'string', 'max' => 1000],
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
            'product_id' => 'Product ID',
            'rating' => 'Rating',
            'username' => 'Username',
            'comment' => 'Comment',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}
