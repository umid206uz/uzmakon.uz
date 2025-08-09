<?php

namespace common\models;

use JetBrains\PhpStorm\Pure;
use Yii;

/**
 * This is the model class for table "orders_prepare".
 *
 * @property int $id
 * @property int $order_id
 * @property int $product_id
 * @property string $product_name
 * @property string $client_name
 * @property int $client_phone
 * @property int $admin_id
 * @property int|null $operator_id
 * @property int|null $courier_id
 * @property int $region_id
 * @property int $district_id
 * @property int $order_status
 * @property int $order_date
 * @property int $count
 * @property int $price
 * @property int $time
 * @property int $status
 */
class OrdersPrepare extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orders_prepare';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'product_id', 'product_name', 'client_name', 'client_phone', 'admin_id', 'region_id', 'district_id', 'order_status', 'order_date', 'count', 'price', 'time', 'status'], 'required'],
            [['order_id', 'product_id', 'client_phone', 'admin_id', 'operator_id', 'courier_id', 'region_id', 'district_id', 'order_status', 'order_date', 'count', 'price', 'time', 'status'], 'integer'],
            [['product_name', 'client_name'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */

    public function createNewRecord($order){
        $check = self::findOne(['order_id' => $order->id, 'status' => 0]);
        if (!$check){
            $model = new self();
            $model->order_id = $order->id;
            $model->product_id = $order->product_id;
            $model->product_name = ($order->product) ? $order->product->title : 'not found';
            $model->client_name = ($order->full_name != '') ? $order->full_name : 'not found';
            $model->client_phone = ($order->phone != '') ? $order->phone : 'not found';
            $model->admin_id = $order->user_id;
            $model->region_id = 1;
            $model->district_id = 1;
            $model->order_status = $order->status;
            $model->order_date = (int) $order->text;
            $model->count = $order->count;
            $model->price = $order->price;
            $model->status = 0;
            $model->time = time();
            $model->save(false);
            return $model;
        }else{
            return false;
        }
    }

    public function getOrder(){
        return $this->hasOne(Orders::className(), ['id' => 'order_id']);
    }

    public function getAdmin(){
        return $this->hasOne(User::className(), ['id' => 'admin_id']);
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'order_id' => Yii::t('app', 'Order ID'),
            'product_id' => Yii::t('app', 'Product ID'),
            'product_name' => Yii::t('app', 'Product Name'),
            'client_name' => Yii::t('app', 'Client Name'),
            'client_phone' => Yii::t('app', 'Client Phone'),
            'admin_id' => Yii::t('app', 'Admin ID'),
            'operator_id' => Yii::t('app', 'Operator ID'),
            'courier_id' => Yii::t('app', 'Courier ID'),
            'region_id' => Yii::t('app', 'Region ID'),
            'district_id' => Yii::t('app', 'District ID'),
            'order_status' => Yii::t('app', 'Order Status'),
            'order_date' => Yii::t('app', 'Order Date'),
            'count' => Yii::t('app', 'Count'),
            'price' => Yii::t('app', 'Price'),
            'time' => Yii::t('app', 'Time'),
            'status' => Yii::t('app', 'Status'),
        ];
    }
}
