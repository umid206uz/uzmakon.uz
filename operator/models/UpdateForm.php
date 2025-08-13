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
 * @property integer $status
 * @property integer $competition
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
    public $region_id;
    public $district_id;
    public $take_time;
    public $competition;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['region_id'], 'required', 'message' => Yii::t("app", "Please select a region!")],
            [['status'], 'required', 'message' => Yii::t("app", "Please select a status!")],
            [['competition'], 'required', 'message' => Yii::t("app", "Please choose delivery!")],
            [['comment'], 'required', 'message' => Yii::t("app", "Please enter more information!")],
            [['count'], 'required', 'message' => Yii::t("app", "Please select a count!")],
            [['count', 'status', 'competition'] , 'integer'],
            [['comment'], 'string'],
            [['take_time'], 'string', 'max' => 255],
            [['take_time'],'required', 'message' => Yii::t("app", "Please set a time to pick up!"), 'when' => function($model){
                return ($model->status == 5) ? true : false;
            }, 'whenClient' => "function (attribute, value) {
                return $('#updateform-status').val() == 5;
            }"],
            [['district_id'],'required', 'message' => Yii::t("app", "Please select a district!"), 'when' => function($model){
                return ($model->region_id == 1700) ? false : true;
            }, 'whenClient' => "function (attribute, value) {
                return $('#updateform-region_id').val() != 1700;
            }"]
        ];
    }

    public function OrderUpdate($order){

        if ($order->operator_id === null) {
            return false;
        }

        if ($this->status == 0) {
            $order->operator_id = null;
            $order->take_time = null;
        }
        
        if ($this->take_time) {
            $order->take_time = strtotime($this->take_time);
        }
        
        $order->status = $this->status;
        $order->region_id = $this->region_id;
        $order->district_id = $this->district_id;
        $order->comment = $this->comment;
        $order->competition = $this->competition;
        $order->count = $this->count;
        return $order->save(false);
    }

    public function LoadOrder($order){

        if ($order->take_time != ''){
            $this->take_time = $order->take_time;
        }
        $this->count = $order->count;
        $this->region_id = $order->region_id;
        $this->district_id = $order->district_id;
        $this->competition = $order->competition;
        $this->comment = $order->comment;
    }

    public function getStatus(): array
    {
        return [
            Orders::STATUS_NEW => Yii::t("app", "New"),
            Orders::STATUS_READY_TO_DELIVERY => Yii::t("app", "Ready for delivery"),
            Orders::STATUS_THEN_TAKES => Yii::t("app", "Then takes"),
            Orders::STATUS_HOLD => Yii::t("app", "Hold"),
            Orders::STATUS_RETURNED_OPERATOR => Yii::t("app", "Archive"),
            Orders::STATUS_BLACK_LIST => Yii::t("app", "Black list"),
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'count' => Yii::t("app", "Count"),
            'comment' => Yii::t("app", "Additional Information"),
            'status' => Yii::t("app", "Status"),
            'competition' => Yii::t("app", "Delivery"),
            'district_id' => Yii::t("app", "District"),
            'region_id' => Yii::t("app", "Region"),
        ];
    }
}
