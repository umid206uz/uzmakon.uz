<?php

/* @var $this yii\web\View */
/* @var $model common\models\Orders */
/* @var $item common\models\Orders */
/* @var $counts common\models\Orders */
/* @var $pagination yii\data\Pagination */

use common\models\Orders;
use courier\widget\alert\AlertWidget;
use courier\widget\count\CountWidget;
use courier\widget\order\OrderWidget;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = Yii::t("app", "Returned orders");
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
        <h3 class="page-title"><?=Yii::t("app", "Returned orders")?></h3>
        <!-- END PAGE TITLE-->
        <div class="portlet light bordered">
            <div class="portlet-body util-btn-margin-bottom-5">
                <div class="clearfix">
                    <a href="<?= Url::to(['site/index'])?>" class="demo-loading-btn btn btn-default"> <?=Yii::t("app", "New")?> (<?=Orders::find()->where(['courier_id' => Yii::$app->user->id, 'status' => Orders::STATUS_BEING_DELIVERED])->count()?>) </a>
                    <a href="<?= Url::to(['site/ordered'])?>" class="demo-loading-btn btn btn-default"> <?=Yii::t("app", "Sold")?> (<?=Orders::find()->where(['courier_id' => Yii::$app->user->id, 'status' => Orders::STATUS_DELIVERED])->count()?>) </a>
                    <a href="<?= Url::to(['site/come-back'])?>" class="demo-loading-btn btn btn-primary"> <?=Yii::t("app", "Returned")?> (<?= $counts?>) </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <?= AlertWidget::widget()?>
                <?php foreach ($model as $item):?>
                    <?= OrderWidget::widget([
                        'model' => $item
                    ])?>
                <?php endforeach;?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-5 col-sm-5">
                <div class="dataTables_info" id="sample_1_info" role="status" aria-live="polite">
                    <?= CountWidget::widget([
                        'model' => $model,
                        'count' => $counts,
                        'pagination' => $pagination
                    ])?>
                </div>
            </div>
            <div class="col-md-7 col-sm-7">
                <div class="dataTables_paginate paging_bootstrap_full_number" id="sample_1_paginate">
                    <?=  LinkPager::widget([
                        'pagination' => $pagination,
                        'options' => [
                            'class' => 'pagination bootpag'
                        ]
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
    <!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->