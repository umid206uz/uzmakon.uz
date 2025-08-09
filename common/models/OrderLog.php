<?php

namespace common\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "order_log".
 *
 * @property int $id
 * @property int $order_id
 * @property int $user_id
 * @property int $admin_id
 * @property int|null $old_status
 * @property int|null $new_status
 * @property string|null $time
 */
class OrderLog extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'admin_id'], 'required'],
            [['order_id', 'user_id', 'admin_id', 'old_status', 'new_status'], 'integer'],
            [['time'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */

    public function insertNewOrderLog($order){
        $model = new self();
        $model->user_id = (isset(Yii::$app->user->id)) ? Yii::$app->user->id : 1;
        $model->admin_id = $order->user_id;
        $model->order_id = $order->id;
        $model->old_status = $order->oldAttributes['status'];
        $model->new_status = $order->status;
        $model->time = time();
        $model->save(false);
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getAdmin(): ActiveQuery
    {
        return $this->hasOne(User::className(), ['id' => 'admin_id']);
    }

    public function getOrder(): ActiveQuery
    {
        return $this->hasOne(Orders::className(), ['id' => 'order_id']);
    }

    public function getSelectUser(): array
    {
        return ArrayHelper::map(User::find()->all(), 'id', function ($model){
            return ($model->first_name == '') ? $model->username . ' ' . $model->tell : $model->first_name . ' ' . $model->last_name;
        });
    }

    public function getStatusOld(): string
    {
        if ($this->old_status === Orders::STATUS_NEW){
            return '<span class="label label-info">' . Yii::t("app", "New") .  '</span>';
        }
        elseif ($this->old_status === Orders::STATUS_BEING_DELIVERED){
            return '<span class="label label-warning">' . Yii::t("app", "Being delivered") .  '</span>';
        }
        elseif ($this->old_status === Orders::STATUS_DELIVERED){
            return '<span class="label label-success">' . Yii::t("app", "Delivered") .  '</span>';
        }
        elseif ($this->old_status === Orders::STATUS_RETURNED){
            return '<span class="label label-danger">' . Yii::t("app", "Returned") .  '</span>';
        }
        elseif ($this->old_status === Orders::STATUS_HOLD){
            return '<span class="label bg-gray-active color-palette">' . Yii::t("app", "Hold") .  '</span>';
        }
        elseif ($this->old_status === Orders::STATUS_READY_TO_DELIVERY){
            return '<span class="label label-primary">' . Yii::t("app", "Ready for delivery") .  '</span>';
        }
        elseif ($this->old_status === Orders::STATUS_BLACK_LIST){
            return '<span class="label bg-black-active color-palette">' . Yii::t("app", "Black list") .  '</span>';
        }
        elseif ($this->old_status === Orders::STATUS_THEN_TAKES){
            return '<span class="label bg-navy color-palette">' . Yii::t("app", "Then takes") .  '</span>';
        }
        elseif ($this->old_status === Orders::STATUS_RETURNED_OPERATOR){
            return '<span class="label label-danger">' . Yii::t("app", "Archive") .  '</span>';
        }
        elseif ($this->old_status === Orders::STATUS_PREPARING){
            return '<span class="label bg-purple-active color-palette">' . Yii::t("app", "Preparing") .  '</span>';
        }
        elseif ($this->old_status === Orders::STATUS_FEEDBACK){
            return '<span class="label bg-purple-active color-palette">' . Yii::t("app", "Feedback") .  '</span>';
        }
        else {
            return (string) $this->old_status;
        }
    }

    public function getStatusNew(): string
    {
        if ($this->new_status === Orders::STATUS_NEW){
            return '<span class="label label-info">' . Yii::t("app", "New") .  '</span>';
        }
        elseif ($this->new_status === Orders::STATUS_BEING_DELIVERED){
            return '<span class="label label-warning">' . Yii::t("app", "Being delivered") .  '</span>';
        }
        elseif ($this->new_status === Orders::STATUS_DELIVERED){
            return '<span class="label label-success">' . Yii::t("app", "Delivered") .  '</span>';
        }
        elseif ($this->new_status === Orders::STATUS_RETURNED){
            return '<span class="label label-danger">' . Yii::t("app", "Returned") .  '</span>';
        }
        elseif ($this->new_status === Orders::STATUS_HOLD){
            return '<span class="label bg-gray-active color-palette">' . Yii::t("app", "Hold") .  '</span>';
        }
        elseif ($this->new_status === Orders::STATUS_READY_TO_DELIVERY){
            return '<span class="label label-primary">' . Yii::t("app", "Ready for delivery") .  '</span>';
        }
        elseif ($this->new_status === Orders::STATUS_BLACK_LIST){
            return '<span class="label bg-black-active color-palette">' . Yii::t("app", "Black list") .  '</span>';
        }
        elseif ($this->new_status === Orders::STATUS_THEN_TAKES){
            return '<span class="label bg-navy color-palette">' . Yii::t("app", "Then takes") .  '</span>';
        }
        elseif ($this->new_status === Orders::STATUS_RETURNED_OPERATOR){
            return '<span class="label label-danger">' . Yii::t("app", "Archive") .  '</span>';
        }
        elseif ($this->new_status === Orders::STATUS_PREPARING){
            return '<span class="label bg-purple-active color-palette">' . Yii::t("app", "Preparing") .  '</span>';
        }
        elseif ($this->new_status === Orders::STATUS_FEEDBACK){
            return '<span class="label bg-purple-active color-palette">' . Yii::t("app", "Feedback") .  '</span>';
        }
        else {
            return (string) $this->new_status;
        }
    }


    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'order_id' => Yii::t('app', 'Order ID'),
            'user_id' => Yii::t('app', 'User'),
            'admin_id' => Yii::t('app', 'Admin'),
            'old_status' => Yii::t('app', 'Old status'),
            'new_status' => Yii::t('app', 'New status'),
            'time' => Yii::t('app', 'Practice date'),
        ];
    }
}
