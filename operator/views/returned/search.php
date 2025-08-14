<?php

/* @var $this yii\web\View */
/* @var $pagination yii\data\Pagination */
/* @var $counts common\models\OrdersReturn */
/* @var $model common\models\OrdersReturn */
/* @var $item common\models\OrdersReturn */
/* @var $key string */

use operator\assets\AppAsset;
use operator\widget\alert\AlertWidget;
use operator\widget\count\CountWidget;
use yii\web\View;
use yii\widgets\LinkPager;
use yii\bootstrap\Modal;
use operator\widget\order\OrderWidget;
use yii\helpers\Url;

$this->title = "Qidiruv natijalari";
$this->registerCssFile(Yii::$app->request->BaseUrl . 'pages/css/error.min.css', ['position' => View::POS_END, 'depends' => [AppAsset::className()]]);
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
            <h3 class="page-title"> "<?=$key?>" bo'yicha qidiruv natijalari </h3>
            <!-- END PAGE TITLE-->
            <?php if (!empty($model)):?>
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <?= AlertWidget::widget()?>
                        <div class="portlet-body">
                            <div class="row">
                                <?php foreach ($model as $item):?>
                                    <?= OrderWidget::widget([
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
            <?php else:?>
                <div class="row">
                    <div class="col-md-12 page-404">
                        <div class="number font-green"> 404 </div>
                        <div class="details">
                            <h3><?=Yii::t("app", "No results found!")?></h3>
                            <p> <?=Yii::t("app", "We could not find the orders you were looking for.")?>
                                <br>
                                <a href="/"> <?=Yii::t("app", "Return home")?> </a> <?=Yii::t("app", "or keep searching")?> </p>
                            <form action="<?= Url::to(['site/search'])?>" method="GET">
                                <div class="input-group input-medium">
                                    <input name="key" type="text" class="form-control" placeholder="<?=Yii::t("app", "Search")?>...">
                                    <span class="input-group-btn">
                                        <button type="submit" class="btn green">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                </div>
                                <!-- /input-group -->
                            </form>
                        </div>
                    </div>
                </div>
            <?php endif;?>
        </div>
        <!-- END CONTENT BODY -->
    </div>
    <!-- END CONTENT -->
<?php
Modal::begin([
    'header' => "<h4>" . Yii::t("app", "Change status") . "</h4>",
    'id' => "myModal",
    "size" => "modal-lg",
]);

echo "<div id='modalContent'>
    
    </div>";

Modal::end();
?>