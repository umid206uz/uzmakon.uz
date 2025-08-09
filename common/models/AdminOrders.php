<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "admin_orders".
 *
 * @property int $id
 * @property int $order_id
 * @property int $admin_id
 * @property int $amount
 * @property int $status
 * @property int $debit
 * @property string $created_date
 * @property string|null $payed_date
 */
class AdminOrders extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'admin_orders';
    }

    /**
     * {@inheritdoc}
     */

    const STATUS_NOT_PAID = 0;
    const STATUS_PAID = 1;

    const DEBIT_RIGHT = 1;
    const DEBIT_DEBT = 0;
    
    public function rules()
    {
        return [
            [['order_id', 'admin_id', 'amount', 'status', 'created_date'], 'required'],
            [['order_id', 'admin_id', 'amount', 'status', 'debit'], 'integer'],
            [['created_date', 'payed_date'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */

    public function insertNew($order) {
        if (!self::find()->where(['order_id' => $order->id])->exists()) {
            $model = new self();
            $model->order_id = $order->id;
            $model->admin_id = $order->user_id;
            $model->amount = $order->product->pay;
            $model->status = self::STATUS_NOT_PAID;
            $model->created_date = time();
            $model->save(false);
        }
    }

    public function InsertDebt($order){
        $model = new self();
        $model->order_id = $order->id;
        $model->admin_id = $order->user_id;
        $model->amount = $order->product->pay;
        $model->status = self::STATUS_NOT_PAID;
        $model->debit = self::DEBIT_DEBT;
        $model->created_date = time();
        $model->save(false);
    }

    public function getStatusForPayment(): string
    {
        if ($this->status == self::STATUS_PAID) {
            return '<span class="label label-success">'. Yii::t("app", "Paid") .'</span>';
        }else {
            return '<span class="label label-danger">'. Yii::t("app", "Not paid") .'</span>';
        }
    }

    public function getStatusForPanel(): string
    {
        if ($this->status == self::STATUS_PAID){
            return '<span class="badge badge-success">' . Yii::t("app", "Paid") . '</span>';
        }elseif ($this->status == self::STATUS_NOT_PAID){
            if ($this->payed_date){
                return '<span class="badge badge-warning">' . Yii::t("app", "Partially paid") . '</span>';
            }else{
                return '<span class="badge badge-danger">' . Yii::t("app", "Not paid") . '</span>';
            }
        }else{
            return (string) $this->status;
        }
    }

    public function getDebitForCreator(): string
    {
        if ($this->debit == self::DEBIT_RIGHT){
            return '<span class="label label-success">' . Yii::t("app", "Haqdor") . '</span>';
        }elseif ($this->debit == self::DEBIT_DEBT){
            return '<span class="label label-danger">' . Yii::t("app", "Qarzdor") . '</span>';
        }else{
            return (string) $this->debit;
        }
    }

    public function getDebitForPanel(): string
    {
        if ($this->debit == self::DEBIT_RIGHT){
            return '<span class="badge light badge-success">' . Yii::t("app", "Haqdor") . '</span>';
        }elseif ($this->debit == self::DEBIT_DEBT){
            return '<span class="badge light badge-danger">' . Yii::t("app", "Qarzdor") . '</span>';
        }else{
            return (string) $this->debit;
        }
    }

    public function getOrder(): ActiveQuery
    {
        return $this->hasOne(Orders::className(), ['id' => 'order_id']);
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'order_id' => Yii::t('app', 'Order ID'),
            'admin_id' => Yii::t('app', 'Admin ID'),
            'amount' => Yii::t('app', 'Amount'),
            'status' => Yii::t('app', 'Status'),
            'created_date' => Yii::t('app', 'Created Date'),
            'payed_date' => Yii::t('app', 'Payed Date'),
            'debit' => Yii::t('app', 'Income type'),
        ];
    }
}
