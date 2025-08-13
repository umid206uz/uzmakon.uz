<?php
namespace operator\models;

use common\models\Orders;
use Yii;
use yii\base\Model;
/**
 * UpdateForm model
 *
 * @property integer $count
 * @property string $comment
 * @property string $send_time
 * @property string $take_time
 * @property integer $region_id
 * @property integer $district_id
 * @property integer $status
 * @property integer $control
 * @property integer $delivery_price
 * @property integer|null $additional_phone
 * @property string|null $additional_address
 */
/**
 * Login form
 */
class UpdateForm extends Model
{
    public $count;
    public $comment;
    public $send_time;
    public $status;
    public $take_time;
    public $control;
    public $delivery_price;
    public $additional_phone;
    public $additional_address;
    public $region_id;
    public $district_id;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['region_id'], 'required', 'message' => Yii::t("app", "Please select a region!")],
            [['district_id'],'required', 'message' => Yii::t("app", "Please select a district!"), 'when' => function($model){
                return ($model->region_id == 1700) ? false : true;
            }, 'whenClient' => "function (attribute, value) {
                return $('#updateform-region_id').val() != 1700;
            }"],
            [['status'], 'required', 'message' => Yii::t("app", "Please select a status!")],
            [['comment'], 'required', 'message' => Yii::t("app", "Please enter more information!")],
            [['count'], 'required', 'message' => Yii::t("app", "Please select a count!")],
            [['count', 'status', 'district_id', 'region_id', 'control'] , 'integer'],
            [['comment', 'additional_phone', 'additional_address', 'take_time'], 'string'],
            [['take_time'],'required', 'message' => Yii::t("app", "Please set a time to pick up!"), 'when' => function($model){
                return ($model->status == 5) ? true : false;
            }, 'whenClient' => "function (attribute, value) {
                return $('#updateform-status').val() == 5;
            }"],
            [['delivery_price'],'required', 'message' => Yii::t("app", "Please enter the shipping fee!"), 'when' => function($model){
                return ($model->control == 1) ? true : false;
            }, 'whenClient' => "function (attribute, value) {
                return $('#updateform-control').val() == 1;
            }"]
        ];
    }

    public function OrderUpdate($order){

        if ($order->operator_id === null || $order->operator_id != Yii::$app->user->id) {
            return false;
        }

        if ($this->status == Orders::STATUS_NEW) {
            $order->operator_id = null;
            $order->take_time = null;
        }

        $order->take_time = strtotime($this->take_time) ?: $order->take_time;
        $order->competition = ($this->control == 2) ? 0 : $this->delivery_price;
        $order->is_then = $order->is_then == 1 ? 0 : $order->is_then;
        $order->is_hold = $order->is_hold == 1 ? 0 : $order->is_hold;
        $order->status = $this->status;
        $order->control_id = $this->control;
        $order->region_id = $this->region_id;
        $order->district_id = $this->district_id;
        $order->additional_phone = $this->additional_phone;
        $order->addres = $this->additional_address;
        $order->comment = $this->comment;
        $order->count = $this->count;
        return $order->save(false);
    }

    public function LoadOrder($order){
        $this->take_time = $order->take_time ? Yii::$app->formatter->getDateWithoutTime($order->take_time) : $this->take_time;
        $this->delivery_price = $order->competition ?? $this->delivery_price;
        $this->control = $order->control_id;
        $this->region_id = $order->region_id;
        $this->district_id = $order->district_id;
        $this->count = $order->count;
        $this->additional_phone = $order->additional_phone;
        $this->additional_address = $order->addres;
        $this->comment = $order->comment;
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'count' => Yii::t("app", "Count"),
            'comment' => Yii::t("app", "Additional Information"),
            'additional_phone' => Yii::t("app", "Additional phone number"),
            'additional_address' => Yii::t("app", "Additional address"),
            'status' => Yii::t("app", "Status"),
            'control' => Yii::t("app", "Delivery type"),
            'delivery_price' => Yii::t("app", "Delivery price"),
            'district_id' => Yii::t("app", "District"),
            'region_id' => Yii::t("app", "Region"),
        ];
    }
}
