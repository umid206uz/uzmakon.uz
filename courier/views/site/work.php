<?php

/* @var $this yii\web\View */
/* @var $pagination yii\data\Pagination */
/* @var $counts common\models\Orders */
/* @var $model common\models\Orders */
/* @var $item common\models\Orders */

use common\models\Orders;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use courier\widget\alert\AlertWidget;
use courier\widget\count\CountWidget;
use courier\widget\order\OrderWidget;
use kartik\dialog\Dialog;

$this->title = "Kuryer bo'limi";
?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <!-- BEGIN PAGE BAR -->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="/"><?=Yii::t("app", "Home")?></a>
                </li>
            </ul>
        </div>
        <!-- END PAGE BAR -->
        <!-- BEGIN PAGE TITLE-->
        <h3 class="page-title"><?=Yii::t("app", "Office")?></h3>
        <!-- END PAGE TITLE-->
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <?= AlertWidget::widget()?>
                <?php foreach ($model as $item):?>
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject font-dark bold uppercase">#<?=$item->id?> / <?=date("d.m.Y H:i", $item->delivery_time)?></span>
                            </div>
                            <div class="actions">
                                <span class="label label-success"><?=$item->statuses?></span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <strong><?=Yii::t("app", "Client")?></strong>: <?= Html::encode($item->full_name) ?><br>
                            <strong><?=Yii::t("app", "Phone")?></strong>: <?=Yii::$app->formatter->asPhone($item->phone)?><br>
                            <strong><?=Yii::t("app", "Shipping Address")?></strong>: <?=$item->country?> <?=$item->addres?><br>
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
                            <?= Html::a('<i class="fa fa-times"></i>',
                                ['order-complete', 'id' => $item->id, 'status' => Orders::STATUS_RETURNED],
                                [
                                    'data-confirm' => 'Buyurtma qaytariladi!',
                                    'class' => 'btn btn-lg red',
                                    'data-method' => 'post'
                                ]
                            ); ?>
                            <?= Html::a('<i class="fa fa-chevron-down"></i>',
                                ['order-complete', 'id' => $item->id, 'status' => Orders::STATUS_RETURNED],
                                [
                                    'data-confirm' => 'Buyurtma tasdiqlanadi!',
                                    'class' => 'btn btn-lg blue',
                                    'data-method' => 'post'
                                ]
                            ); ?>
                            <a href="tel:<?=$item->phone?>" class="btn btn-lg green"> <i class="fa fa-phone"></i> </a>
                        </div>
                    </div>
                <?php endforeach;?>
            </div>
        </div>
    </div>
    <!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->