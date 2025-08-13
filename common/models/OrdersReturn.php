<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "orders_return".
 *
 * @property int $id
 * @property int $order_id
 * @property int|null $new_order_id
 * @property int $product_id
 * @property int|null $operator_id
 * @property int|null $admin_id
 * @property int|null $region_id
 * @property int|null $district_id
 * @property int|null $price
 * @property int $status
 * @property int $order_date
 * @property int $created_date
 * @property int $take_time
 * @property int $delivery_type
 * @property int $delivery_price
 * @property int $count
 * @property string|null $customer_name
 * @property string|null $customer_phone
 * @property string|null $address
 * @property string|null $comment
 */
class OrdersReturn extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'orders_return';
    }

    /**
     * {@inheritdoc}
     */

    const STATUS_NEW = 0;
    const STATUS_BEING_DELIVERED = 1;
    const STATUS_DELIVERED = 2;
    const STATUS_RETURNED = 3;
    const STATUS_READY_TO_DELIVERY = 4;
    const STATUS_THEN_TAKES = 5;
    const STATUS_HOLD = 6;
    const STATUS_COURIER_RETURNED = 7;
    const STATUS_BLACK_LIST = 8;
    const STATUS_ARCHIVE = 9;
    const STATUS_PREPARING = 10;
    const STATUS_FEEDBACK = 11;

    public function rules()
    {
        return [
            [['order_id', 'product_id', 'order_date'], 'required'],
            [
                [
                    'order_id', 'new_order_id', 'product_id',
                    'operator_id', 'admin_id', 'region_id', 'district_id',
                    'price', 'status', 'order_date', 'created_date', 'take_time',
                    'delivery_type', 'delivery_price', 'count'
                ],
                'integer'
            ],
            [['customer_name', 'customer_phone', 'address', 'comment'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */

    public function insertOrder($order){
        if (!self::find()->where(['order_id' => $order->id])->exists() && $order->returned_id == null){
            $model = new self();
            $model->order_id = $order->id;
            $model->product_id = $order->product_id;
            $model->product_id = $order->product_id;
            $model->admin_id = $order->user_id;
            $model->region_id = $order->region_id;
            $model->district_id = $order->district_id;
            $model->price = $order->price;
            $model->order_date = $order->text;
            $model->customer_name = $order->full_name;
            $model->customer_phone = $order->phone;
            $model->comment = $order->comment;
            $model->address = $order->addres;
            $model->price = $order->product->sale;
            $model->count = $order->count;
            $model->created_date = time();
            $model->save();
        }
    }

    public function getProduct(): ActiveQuery
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    public function getOperator(): ActiveQuery
    {
        return $this->hasOne(User::className(), ['id' => 'operator_id']);
    }

    public function getAdmin(): ActiveQuery
    {
        return $this->hasOne(User::className(), ['id' => 'admin_id']);
    }

    public function getRegion(): ActiveQuery
    {
        return $this->hasOne(Regions::className(), ['code' => 'region_id']);
    }

    public function getDistrict(): ActiveQuery
    {
        return $this->hasOne(Regions::className(), ['code' => 'district_id']);
    }

    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'order_id' => Yii::t('app', 'Order ID'),
            'new_order_id' => Yii::t('app', 'New order ID'),
            'product_id' => Yii::t('app', 'Product'),
            'operator_id' => Yii::t('app', 'Operator'),
            'admin_id' => Yii::t('app', 'Admin ID'),
            'region_id' => Yii::t('app', 'Region'),
            'district_id' => Yii::t('app', 'District'),
            'price' => Yii::t('app', 'Price'),
            'status' => Yii::t('app', 'Status'),
            'order_date' => Yii::t('app', 'Order date'),
            'created_date' => Yii::t('app', 'Created Date'),
            'customer_name' => Yii::t('app', 'Client'),
            'customer_phone' => Yii::t('app', 'Phone number'),
            'address' => Yii::t('app', 'Shipping Address'),
            'comment' => Yii::t('app', 'Comment'),
            'take_time' => Yii::t('app', 'Take time'),
            'delivery_type' => Yii::t('app', 'Delivery type'),
            'delivery_price' => Yii::t('app', 'Delivery price'),
            'count' => Yii::t('app', 'Count'),
        ];
    }
}
