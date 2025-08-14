<?php

/* @var $this yii\web\View */
/* @var $pagination yii\data\Pagination */
/* @var $counts common\models\Orders */
/* @var $model common\models\Orders */
/* @var $item common\models\Orders */

use operator\widget\alert\AlertWidget;
use operator\widget\count\CountWidget;
use operator\widget\orders\OrdersWidget;
use yii\widgets\LinkPager;

$this->title = Yii::t("app", "Being delivered orders");
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
        <h3 class="page-title"><?=Yii::t("app", "Being delivered orders")?></h3>
        <!-- END PAGE TITLE-->
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <?= AlertWidget::widget()?>
                <div class="portlet-body">
                    <div class="row">
                        <?php foreach ($model as $item):?>
                            <?= OrdersWidget::widget([
                                'model' => $item
                            ])?>
                        <?php endforeach;?>
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
            </div>
        </div>
    </div>
    <!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->