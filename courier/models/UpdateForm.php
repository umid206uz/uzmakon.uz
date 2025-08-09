<?php
namespace courier\models;

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
 * @property string $country
 * @property integer $status
 * @property integer $control
 * @property integer $delivery_price
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
    public $country;
    public $take_time;
    public $control;
    public $delivery_price;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['country'], 'required', 'message' => Yii::t("app", "Please select a region!")],
            [['status'], 'required', 'message' => Yii::t("app", "Please select a status!")],
            [['comment'], 'required', 'message' => Yii::t("app", "Please enter more information!")],
            [['count'], 'required', 'message' => Yii::t("app", "Please select a count!")],
            // rememberMe must be a boolean value
            [['count', 'status', 'delivery_price', 'control'] , 'integer'],
            [['comment'], 'string'],
            [['take_time', 'country'], 'string', 'max' => 255]
        ];
    }

    public function OrderUpdate($order){
        if ($order->courier_id == Yii::$app->user->id){
            $order->status = $this->status;
            $order->comment = $this->comment;
            $order->updated_date = date('Y-m-d H:i:s');
            $order->save(false);
            return true;
        }else{
            return false;
        }
    }

    public function LoadOrder($order){

        if ($order->take_time != ''){
            $this->take_time = $order->take_time;
        }
        if ($order->competition){
            $this->delivery_price = $order->competition;
        }
        if ($order->control_id){
            $this->control = $order->control_id;
        }
        $this->count = $order->count;
        $this->country = $order->country;
        $this->comment = $order->comment;
    }

    public function getStatus(){
        return [
            Orders::STATUS_RETURNED => Yii::t("app", "Returned"),
            Orders::STATUS_DELIVERED => Yii::t("app", "Delivered"),
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'count' => Yii::t("app", "Count"),
            'comment' => Yii::t("app", "Additional Information"),
            'country' => Yii::t("app", "Region"),
            'status' => Yii::t("app", "Status"),
            'control' => Yii::t("app", "Delivery type"),
            'delivery_price' => Yii::t("app", "Delivery price"),
        ];
    }
}
