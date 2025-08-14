<?php

/* @var $item common\models\Orders */
/* @var $product common\models\Product */

use common\models\Orders;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
$product = $item->product;
$operator_id = Yii::$app->user->id;
$action = Yii::$app->controller->action->id;
$this->registerJs(<<<JS
$('.modalButton').click(function(){
    $('#myModal').modal('show')
        .find('#modalContent')
        .load($(this).attr('value'));
});
$('.orderDetail').click(function(){
    $('#orderDetailModal').modal('show')
        .find('#orderDetailContent')
        .load($(this).attr('value'));
});
JS
    , 3)
?>
    <div class="col-md-4">
        <div class="portlet light bordered" style="background-color: #f9f9f9; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-basket font-<?=Yii::$app->status->colorForOperatorOrCourier($item->status)?>"></i>
                    <span class="caption-subject font-<?=Yii::$app->status->colorForOperatorOrCourier($item->status)?> bold uppercase">ID: #<?=$item->id?></span>
                </div>
                <div class="actions pull-right">
                    <span class="label <?=Yii::$app->status->colorForOperatorOrCourierStatus($item->status)?>"><?=Yii::$app->status->allStatusTranslate($item->status)?></span>
                </div>
            </div>
            <div class="portlet-body">
                <div>
                    <strong><i class="fa fa-user"></i> <?=Yii::t("app","Customer")?>:</strong> <?= Html::encode($item->full_name) ?><br>
                    <strong><i class="fa fa-phone"></i> <?=Yii::t("app","Phone number")?>:</strong>
                    <a id="phone_id_<?=$item->id?>" href="tel:<?=($item->operator_id && $item->operator_id == $operator_id ? $item->phone: null)?>"><?=Yii::$app->formatter->asPhoneOperator($item->phone, $item, $operator_id)?></a><br>
                    <strong><i class="fa fa-clock-o"></i> <?=Yii::t("app","Order date")?>:</strong> <?=Yii::$app->formatter->getDate($item->text)?><br>
                    <?php if ($item->status == Orders::STATUS_THEN_TAKES):?>
                        <strong><i class="fa fa-clock-o"></i> <?=Yii::t("app","Take time")?>:</strong> <?=Yii::$app->formatter->getDateWithoutTime($item->take_time)?>
                    <?php endif;?>
                </div>
                <hr>
                <div>
                    <strong><?=Yii::t("app","Order Details")?>:</strong>
                    <ul class="list-group">
                        <li class="list-group-item"><?=$product->title?> x <?=$item->count?></li>
                    </ul>
                </div>
                <div class="clearfix">
                    <?= Html::button(($item->operator_id === null ? '<i class="fa fa-check"></i> ' . Yii::t("app","Acceptance") : '<i class="fa fa-check-square"></i> ' . Yii::t("app","Accepted")), [
                        'class' => 'btn btn-primary orders',
                        'data-order_id' => $item->id,
                        'disabled' => $item->operator_id !== null ? 'disabled' : false,
                    ]); ?>
                    <?php if ($item->status != Orders::STATUS_BEING_DELIVERED && $item->status != Orders::STATUS_DELIVERED):?>
                        <?= Html::button('<i class="fa fa-pencil"></i> ' . Yii::t("app","Change"), [
                            'id' => 'modalButton',
                            'class' => 'btn btn-info modalButton',
                            'value' => Url::to(['operator/ajax', 'id' => $item->id]),
                        ]); ?>
                    <?php endif;?>
                    <?= Html::button('<i class="fa fa-eye"></i>', [
                        'class' => 'btn btn-icon-only btn-default orderDetail',
                        'value' => Url::to(['operator/order-detail', 'id' => $item->id]),
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
<?php
Modal::begin([
    'header' => "<h4>" . Yii::t("app","Change status") . "</h4>",
    'id' => "myModal",
    "size" => "modal-lg",
]);

echo "<div id='modalContent'></div>";

Modal::end();
Modal::begin([
    'header' => "<h4>" . Yii::t("app","Order Details") . "</h4>",
    'id' => "orderDetailModal",
    "size" => "modal-lg",
]);

echo "<div id='orderDetailContent' style='padding: 30px; background-color: #f4f7fc;'></div>";

Modal::end();
?>