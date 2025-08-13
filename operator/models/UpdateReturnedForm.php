<?php
namespace operator\models;

use common\models\Orders;
use common\models\OrdersReturn;
use Yii;
use yii\base\Model;
/**
 * UpdateReturnedForm model
 *
 * @property string $comment
 * @property string $address
 * @property integer $status
 * @property integer $take_time
 * @property integer $delivery_type
 * @property integer $delivery_price
 * @property integer $region_id
 * @property integer $district_id
 * @property integer $count
 */
/**
 * Login form
 */
class UpdateReturnedForm extends Model
{
    public $comment;
    public $address;
    public $take_time;
    public $delivery_type;
    public $delivery_price;
    public $status;
    public $region_id;
    public $district_id;
    public $count;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['region_id'], 'required', 'message' => Yii::t("app", "Please select a region!")],
            [['status'], 'required', 'message' => Yii::t("app", "Please select a status!")],
            [['comment'], 'required', 'message' => Yii::t("app", "Please enter more information!")],
            [['comment', 'address', 'take_time'], 'string'],
            [['count', 'status', 'delivery_type', 'delivery_price'] , 'integer'],
            [['take_time'],'required', 'message' => Yii::t("app", "Please set a time to pick up!"), 'when' => function($model){
                return ($model->status == 5) ? true : false;
            }, 'whenClient' => "function (attribute, value) {
                return $('#updatereturnedform-status').val() == 5;
            }"],
            [['district_id'],'required', 'message' => Yii::t("app", "Please select a district!"), 'when' => function($model){
                return ($model->region_id == 1700) ? false : true;
            }, 'whenClient' => "function (attribute, value) {
                return $('#updatereturnedform-region_id').val() != 1700;
            }"]
        ];
    }

    public function OrderUpdate($order): bool
    {
        if ($order->operator_id === null) {
            return false;
        }

        if ($this->status == OrdersReturn::STATUS_NEW) {
            $order->operator_id = null;
            $order->take_time = null;
        }

        $order->take_time = strtotime($this->take_time) ?: $order->take_time;
        $order->status = $this->status;
        $order->region_id = $this->region_id;
        $order->district_id = $this->district_id;
        $order->comment = $this->comment;
        $order->address = $this->address;
        $order->delivery_type = $this->delivery_type;
        $order->delivery_price = $this->delivery_price;
        $order->count = $this->count;
        if ($this->status == OrdersReturn::STATUS_READY_TO_DELIVERY){
            $order->new_order_id = (new Orders())->insertFromOperatorReturned($order);
        }
        return $order->save(false);
    }

    public function LoadOrder($order){
        if ($order->take_time){
            $this->take_time = date('d.m.Y', $order->take_time);
        }
        $this->count = $order->count;
        $this->delivery_type = $order->delivery_type;
        $this->delivery_price = $order->delivery_price;
        $this->region_id = $order->region_id;
        $this->district_id = $order->district_id;
        $this->comment = $order->comment;
        $this->address = $order->address;
    }

    public function getStatus(): array
    {
        return [
            OrdersReturn::STATUS_NEW => Yii::t("app", "New"),
            OrdersReturn::STATUS_READY_TO_DELIVERY => Yii::t("app", "Ready for delivery"),
            OrdersReturn::STATUS_THEN_TAKES => Yii::t("app", "Then takes"),
            OrdersReturn::STATUS_HOLD => Yii::t("app", "Hold"),
            OrdersReturn::STATUS_ARCHIVE => Yii::t("app", "Archive"),
            OrdersReturn::STATUS_BLACK_LIST => Yii::t("app", "Black list"),
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'count' => Yii::t("app", "Count"),
            'comment' => Yii::t("app", "Additional Information"),
            'address' => Yii::t("app", "Additional address"),
            'status' => Yii::t("app", "Status"),
            'district_id' => Yii::t("app", "District"),
            'region_id' => Yii::t("app", "Region"),
            'delivery_type' => Yii::t("app", "Delivery type"),
            'delivery_price' => Yii::t("app", "Delivery price"),
        ];
    }
}
