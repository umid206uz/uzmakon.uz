<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "additional_product".
 *
 * @property int $id
 * @property int $order_id
 * @property int $product_id
 * @property int $count
 * @property int $one_price
 * @property int $total_price
 * @property int $created_date
 */
class AdditionalProduct extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'additional_product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'created_date'], 'required'],
            [['product_id'], 'required', 'message' => Yii::t("app","Select a product")],
            [['count'], 'required', 'message' => Yii::t("app","Enter the count")],
            [['order_id', 'product_id', 'count', 'one_price', 'total_price', 'created_date'], 'integer'],
        ];
    }

    public function getOrder(): ActiveQuery
    {
        return $this->hasOne(Orders::className(), ['id' => 'order_id']);
    }

    public function getProduct(): ActiveQuery
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'order_id' => Yii::t('app', 'Order ID'),
            'product_id' => Yii::t('app', 'Product'),
            'count' => Yii::t('app', 'Count'),
            'one_price' => Yii::t('app', 'One Price'),
            'total_price' => Yii::t('app', 'Total Price'),
            'created_date' => Yii::t('app', 'Created Date'),
        ];
    }
}
