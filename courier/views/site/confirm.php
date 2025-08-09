<?php

/* @var $this yii\web\View */
/* @var $pagination yii\data\Pagination */
/* @var $counts common\models\Orders */
/* @var $model common\models\Orders */
/* @var $item common\models\Orders */

use common\models\Orders;
use courier\widget\alert\AlertWidget;
use courier\widget\order\OrderWidget;
use yii\helpers\Url;

$this->title = Yii::t("app", "Confirmation");
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
        <h3 class="page-title"><?=Yii::t("app", "Confirmation")?></h3>
        <!-- END PAGE TITLE-->
        <div class="portlet light bordered">
            <div class="portlet-body util-btn-margin-bottom-5">
                <div class="clearfix">
                    <a href="<?= Url::to(['site/index'])?>" class="demo-loading-btn btn btn-default"> <?=Yii::t("app", "New")?> (<?=Orders::find()->where(['courier_id' => Yii::$app->user->id, 'status' => Orders::STATUS_BEING_DELIVERED])->count()?>) </a>
                    <a href="<?= Url::to(['site/ordered'])?>" class="demo-loading-btn btn btn-default"> <?=Yii::t("app", "Sold")?> (<?=Orders::find()->where(['courier_id' => Yii::$app->user->id, 'status' => Orders::STATUS_DELIVERED])->count()?>) </a>
                    <a href="<?= Url::to(['site/come-back'])?>" class="demo-loading-btn btn btn-default"> <?=Yii::t("app", "Returned")?> (<?=Orders::find()->where(['courier_id' => Yii::$app->user->id, 'status' => Orders::STATUS_RETURNED])->count()?>) </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <?= AlertWidget::widget()?>
                <?= OrderWidget::widget([
                    'model' => $model
                ])?>
            </div>
        </div>
    </div>
    <!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->