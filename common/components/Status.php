<?php

namespace common\components;

use common\models\Orders;
use common\models\Payment;
use Yii;
use yii\i18n\Formatter;

class Status extends Formatter {

    public function allStatusLabel($status): string
    {
        if ($status === Orders::STATUS_NEW){
            return '<span class="label label-info">' . Yii::t("app","New") .  '</span>';
        } elseif ($status === Orders::STATUS_BEING_DELIVERED){
            return '<span class="label label-warning">' . Yii::t("app","Being delivered") .  '</span>';
        } elseif ($status === Orders::STATUS_DELIVERED){
            return '<span class="label label-success">' . Yii::t("app","Delivered") .  '</span>';
        } elseif ($status === Orders::STATUS_RETURNED){
            return '<span class="label label-danger">' . Yii::t("app","Came back") .  '</span>';
        } elseif ($status === Orders::STATUS_HOLD){
            return '<span class="label bg-gray-active color-palette">' . Yii::t("app","Hold") .  '</span>';
        } elseif ($status === Orders::STATUS_READY_TO_DELIVERY){
            return '<span class="label label-primary">' . Yii::t("app","Ready for delivery") .  '</span>';
        } elseif ($status === Orders::STATUS_BLACK_LIST){
            return '<span class="label bg-black-active color-palette">' . Yii::t("app","Black list") .  '</span>';
        } elseif ($status === Orders::STATUS_THEN_TAKES){
            return '<span class="label bg-navy color-palette">' . Yii::t("app","Then takes") .  '</span>';
        } elseif ($status === Orders::STATUS_ARCHIVE){
            return '<span class="label label-danger">' . Yii::t("app","Archive") .  '</span>';
        } elseif ($status === Orders::STATUS_COURIER_RETURNED){
            return '<span class="label label-danger">' . Yii::t("app","Returned (Courier)") .  '</span>';
        } elseif ($status === Orders::STATUS_PREPARING){
            return '<span class="label bg-purple-active color-palette">' . Yii::t("app","Preparing") .  '</span>';
        } elseif ($status === Orders::STATUS_FEEDBACK){
            return '<span class="label bg-purple-active color-palette">' . Yii::t("app","Feedback") .  '</span>';
        } else {
            return (string) $status;
        }
    }
    
    public function allStatusTranslate($status): string
    {
        if ($status == Orders::STATUS_NEW){
            return Yii::t("app", "New");
        }elseif ($status == Orders::STATUS_BEING_DELIVERED){
            return Yii::t("app", "Being delivered");
        }elseif ($status == Orders::STATUS_DELIVERED){
            return Yii::t("app", "Delivered");
        }elseif ($status == Orders::STATUS_RETURNED){
            return Yii::t("app", "Came back");
        }elseif ($status == Orders::STATUS_READY_TO_DELIVERY){
            return Yii::t("app", "Ready for delivery");
        }elseif ($status == Orders::STATUS_BLACK_LIST){
            return Yii::t("app", "Black list");
        }elseif ($status == Orders::STATUS_THEN_TAKES){
            return Yii::t("app", "Then takes");
        }elseif ($status == Orders::STATUS_RETURNED_OPERATOR){
            return Yii::t("app", "Archive");
        }elseif ($status == Orders::STATUS_HOLD){
            return Yii::t("app", "Hold");
        }elseif ($status == Orders::STATUS_PREPARING){
            return Yii::t("app", "Preparing");
        }elseif ($status == Orders::STATUS_FEEDBACK){
            return Yii::t("app", "Feedback");
        }else{
            return (string) $status;
        }
    }

    public function arrayStatusForAdmin(): array
    {
        return [
            Orders::STATUS_NEW => Yii::t("app", "New"),
            Orders::STATUS_READY_TO_DELIVERY => Yii::t("app", "Ready for delivery"),
            Orders::STATUS_BEING_DELIVERED => Yii::t("app", "Being delivered"),
            Orders::STATUS_DELIVERED => Yii::t("app", "Delivered"),
            Orders::STATUS_THEN_TAKES => Yii::t("app", "Then takes"),
            Orders::STATUS_HOLD => Yii::t("app", "Hold"),
            Orders::STATUS_RETURNED => Yii::t("app", "Came back"),
            Orders::STATUS_RETURNED_OPERATOR => Yii::t("app", "Archive"),
            Orders::STATUS_BLACK_LIST => Yii::t("app", "Black list"),
            Orders::STATUS_PREPARING => Yii::t("app", "Preparing"),
            Orders::STATUS_FEEDBACK => Yii::t("app", "Feedback"),
        ];
    }

    public function arrayStatusForOperator(): array
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

    public function colorForOperatorOrCourier($status): string
    {
        if ($status == Orders::STATUS_NEW){
            return 'blue';
        }elseif ($status == Orders::STATUS_RETURNED || $status == Orders::STATUS_RETURNED_OPERATOR){
            return 'red';
        }elseif ($status == Orders::STATUS_DELIVERED){
            return 'green';
        }elseif ($status == Orders::STATUS_BLACK_LIST){
            return 'dark';
        }elseif ($status == Orders::STATUS_BEING_DELIVERED){
            return 'yellow';
        }elseif ($status == Orders::STATUS_READY_TO_DELIVERY){
            return 'blue';
        }elseif ($status == Orders::STATUS_THEN_TAKES){
            return 'takes';
        }elseif ($status == Orders::STATUS_HOLD){
            return 'hold';
        }elseif ($status == Orders::STATUS_PREPARING){
            return 'blue';
        }elseif ($status == Orders::STATUS_FEEDBACK){
            return 'purple';
        }else{
            return (string) $status;
        }
    }

    public function colorForOperatorOrCourierStatus($status): string
    {
        if ($status == Orders::STATUS_NEW) {
            return 'label-info';
        } elseif ($status == Orders::STATUS_RETURNED || $status == Orders::STATUS_RETURNED_OPERATOR) {
            return 'label-danger';
        } elseif ($status == Orders::STATUS_DELIVERED) {
            return 'label-success';
        } elseif ($status == Orders::STATUS_BLACK_LIST) {
            return 'label-black';
        } elseif ($status == Orders::STATUS_BEING_DELIVERED) {
            return 'label-warning';
        } elseif ($status == Orders::STATUS_READY_TO_DELIVERY) {
            return 'label-info';
        } elseif ($status == Orders::STATUS_THEN_TAKES) {
            return 'label-takes';
        } elseif ($status == Orders::STATUS_HOLD) {
            return 'label-hold';
        } elseif ($status == Orders::STATUS_PREPARING) {
            return 'label-warning';
        } elseif ($status == Orders::STATUS_FEEDBACK) {
            return 'label-feedback';
        } else {
            return (string) $status;
        }
    }

    public function getStatusPayment($status): string
    {
        if ($status == Payment::STATUS_PAID) {
            return '<span class="label label-success">' . Yii::t("app", "Paid") . '</span>';
        }elseif ($status == Payment::STATUS_NOT_PAID) {
            return '<span class="label label-danger">' . Yii::t("app", "Not paid") . '</span>';
        }else{
            return (string) $status;
        }
    }

    public function statusForPayment($status): string
    {
        if ($status == Orders::STATUS_NEW){
            return '<span class="label label-primary">'. Yii::t("app", "New") .'</span>';
        }elseif ($status == Orders::STATUS_BEING_DELIVERED){
            return '<span class="label label-warning">'. Yii::t("app", "Being delivered") .'</span>';
        }elseif ($status == Orders::STATUS_DELIVERED){
            return '<span class="label label-success">'. Yii::t("app", "Delivered") .'</span>';
        }elseif ($status == Orders::STATUS_RETURNED){
            return '<span class="label label-danger">'. Yii::t("app", "Returned") .'</span>';
        }elseif ($status == Orders::STATUS_HOLD){
            return '<span class="label label-default">'. Yii::t("app", "Hold") .'</span>';
        }elseif ($status == Orders::STATUS_READY_TO_DELIVERY){
            return '<span class="label label-primary">'. Yii::t("app", "Ready for delivery") .'</span>';
        }elseif ($status == Orders::STATUS_BLACK_LIST){
            return '<span class="label label-danger">'. Yii::t("app", "Black list") .'</span>';
        }elseif ($status == Orders::STATUS_THEN_TAKES){
            return '<span class="label label-warning">'. Yii::t("app", "Then takes") .'</span>';
        }elseif ($status == Orders::STATUS_RETURNED_OPERATOR){
            return '<span class="label label-danger">'. Yii::t("app", "Archive") .'</span>';
        }elseif ($status == Orders::STATUS_COURIER_RETURNED){
            return '<span class="label label-danger">'. Yii::t("app", "Returned (Courier)") .'</span>';
        }elseif ($status == Orders::STATUS_PREPARING){
            return '<span class="label label-primary">'. Yii::t("app", "Preparing") .'</span>';
        }elseif ($status == Orders::STATUS_FEEDBACK){
            return '<span class="label label-info">'. Yii::t("app", "Feedback") .'</span>';
        }else{
            return (string) $status;
        }
    }

    public function statusForPanel($status): string
    {
        if ($status == Orders::STATUS_NEW){
            return '<span class="badge badge-primary">' . Yii::t("app", "New") . '</span>';
        }elseif ($status == Orders::STATUS_BEING_DELIVERED){
            return '<span class="badge badge-warning">' . Yii::t("app", "Being delivered") . '</span>';
        }elseif ($status == Orders::STATUS_DELIVERED){
            return '<span class="badge badge-success">' . Yii::t("app", "Delivered") . '</span>';
        }elseif ($status == Orders::STATUS_RETURNED){
            return '<span class="badge badge-danger">' . Yii::t("app", "Came back") . '</span>';
        }elseif ($status == Orders::STATUS_READY_TO_DELIVERY){
            return '<span class="badge badge-info">' . Yii::t("app", "Ready for delivery") . '</span>';
        }elseif ($status == Orders::STATUS_BLACK_LIST){
            return '<span class="badge badge-dark">' . Yii::t("app", "Black list") . '</span>';
        }elseif ($status == Orders::STATUS_RETURNED_OPERATOR){
            return '<span class="badge badge-danger">' . Yii::t("app", "Archive") . '</span>';
        }elseif ($status == Orders::STATUS_THEN_TAKES){
            return '<span class="badge badge-secondary">' . Yii::t("app", "Then takes") . '</span>';
        }elseif ($status == Orders::STATUS_HOLD){
            return '<span class="badge badge-warning">' . Yii::t("app", "Hold") . '</span>';
        }elseif ($status == Orders::STATUS_PREPARING){
            return '<span class="badge badge-primary">' . Yii::t("app", "Preparing") . '</span>';
        }elseif ($status == Orders::STATUS_FEEDBACK){
            return '<span class="badge badge-primary">' . Yii::t("app", "Feedback") . '</span>';
        }else{
            return (string) $status;
        }
    }
}