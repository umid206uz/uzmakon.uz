<?php

/* @var $item common\models\Orders */

use common\models\Orders;
use yii\helpers\Html;

?>
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject font-dark bold uppercase">#<?=$item->id?> / <?=date("d.m.Y H:i", $item->delivery_time)?></span>
        </div>
        <div class="actions">
            <span class="label <?=Yii::$app->status->colorForOperatorOrCourierStatus($item->status)?>"><?=Yii::$app->status->allStatusTranslate($item->status)?></span>
        </div>
    </div>
    <div class="portlet-body">
        <strong><?=Yii::t("app", "Client")?></strong>: <?= Html::encode($item->full_name) ?><br>
        <strong><?=Yii::t("app", "Phone")?></strong>: <?=Yii::$app->formatter->asPhone($item->phone)?><br>
        <strong><?=Yii::t("app", "Shipping Address")?></strong>: <?=$item->region->name?> <?=$item->district->name?> <?=$item->addres?><br>
        <strong><?=Yii::t("app", "Additional")?></strong>: <?= Html::encode($item->comment) ?>

        <table class="table">
            <thead>
            <tr>
                <th> <?=Yii::t("app", "Product name")?> </th>
                <th> <?=Yii::t("app", "Count")?> </th>
                <th> <?=Yii::t("app", "Price")?> </th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td> <?=$item->product->titleTranslate?> </td>
                <td> <?=$item->count?> </td>
                <td> <?=Yii::$app->formatter->getPrice($item->count*$item->product->sale + $item->competition)?> </td>
            </tr>
            </tbody>
        </table>
        <!-- Button to trigger modal -->

        <?php if ($item->status == Orders::STATUS_BEING_DELIVERED):?>
        <?= Html::a('<i class="fa fa-headphones"></i>',
            ['order-complete', 'id' => $item->id, 'status' => Orders::STATUS_FEEDBACK],
            [
                'data-confirm' => 'Buyurtma qayta aloqaga jo\'natiladi!',
                'class' => 'btn btn-lg btn-warning',
                'data-method' => 'post'
            ]
        ); ?>
        <?= Html::a('<i class="fa fa-times"></i>',
            ['order-complete', 'id' => $item->id, 'status' => Orders::STATUS_RETURNED],
            [
                'data-confirm' => 'Buyurtma qaytariladi!',
                'class' => 'btn btn-lg red',
                'data-method' => 'post'
            ]
        ); ?>
        <?= Html::a('<i class="fa fa-chevron-down"></i>',
            ['order-complete', 'id' => $item->id, 'status' => Orders::STATUS_DELIVERED],
            [
                'data-confirm' => 'Buyurtma tasdiqlanadi!',
                'class' => 'btn btn-lg blue',
                'data-method' => 'post'
            ]
        ); ?>
        <?php endif;?>
        <a href="tel:<?=$item->phone?>" class="btn btn-lg green"> <i class="fa fa-phone"></i> </a>
    </div>
</div>
