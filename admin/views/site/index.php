<?php

/* @var $this yii\web\View */
/* @var $balance integer */
/* @var $probable integer */
/* @var $count_order integer */
/* @var $sold_order integer */
/* @var $returned_order integer */
/* @var $new common\models\Orders */
/* @var $read_to_delivery common\models\Orders */
/* @var $returned_operator common\models\Orders */
/* @var $being_delivered common\models\Orders */
/* @var $delivered common\models\Orders */
/* @var $black_list common\models\Orders */
/* @var $returned common\models\Orders */
/* @var $takes_tomorrow common\models\Orders */
/* @var $hold common\models\Orders */
/* @var $preparing common\models\Orders */
/* @var $archive common\models\Orders */
/* @var $top_users common\models\Orders */
/* @var $top_user common\models\Orders */
/* @var $top_products common\models\Orders */
/* @var $top_product common\models\Orders */

$this->title = 'Dashboard';

use common\models\Orders;
use frontend\widget\alert\AlertWidget;
use yii\helpers\Url;

?>
<!--**********************************
    Content body start
***********************************-->
<div class="content-body">
    <div class="container-fluid">
        <?= AlertWidget::widget()?>
        <!-- row -->
        <div class="row">

            <div class="col-xl-6 col-xxl-6 col-lg-6 col-sm-6">
                <div class="widget-stat card">
                    <div class="card-body p-4">
                        <div class="media ai-icon">
                            <span class="me-3 bgl-primary text-primary">
                                <svg id="icon-revenue" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign">
                                    <line x1="12" y1="1" x2="12" y2="23"></line>
                                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                </svg>
                            </span>
                            <div class="media-body">
                                <p class="mb-1"><?=Yii::t("app", "Basic balance")?></p>
                                <h4 class="mb-0"><?=number_format($balance)?></h4>
                                <span class="badge badge-primary"><?=Yii::t("app", "sum")?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-xxl-6 col-lg-6 col-sm-6">
                <div class="widget-stat card">
                    <div class="card-body p-4">
                        <div class="media ai-icon">
                            <span class="me-3 bgl-success text-success">
                                <svg id="icon-database-widget" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-database">
                                    <ellipse cx="12" cy="5" rx="9" ry="3"></ellipse>
                                    <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path>
                                    <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path>
                                </svg>
                            </span>
                            <div class="media-body">
                                <p class="mb-1"><?=Yii::t("app", "Hold balance")?></p>
                                <h4 class="mb-0"><?=number_format($probable)?></h4>
                                <span class="badge badge-success"><?=Yii::t("app", "sum")?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
                <div style="cursor: pointer" onclick="location.href='<?= Url::to(['/site/orders'])?>'" class="widget-stat card bg-success">
                    <div class="card-body p-4">
                        <div class="media">
                            <span class="me-3">
                                <i class="la la-users"></i>
                            </span>
                            <div class="media-body text-white text-end">
                                <p class="mb-1"><?=Yii::t("app", "All orders")?></p>
                                <h3 class="text-white"><?=number_format($count_order)?></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
                <div style="cursor: pointer" onclick="location.href='<?= Url::to(['/site/order', 'status' => Orders::STATUS_NEW])?>'" class="widget-stat card bg-info">
                    <div class="card-body p-4">
                        <div class="media">
                            <span class="me-3">
                                <i class="la la-plus-square"></i>
                            </span>
                            <div class="media-body text-white text-end">
                                <p class="mb-1"><?=Yii::t("app", "New orders")?></p>
                                <h3 class="text-white"><?=number_format($new)?></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
                <div style="cursor: pointer" onclick="location.href='<?= Url::to(['/site/order', 'status' => Orders::STATUS_BEING_DELIVERED])?>'" class="widget-stat card bg-blue">
                    <div class="card-body  p-4">
                        <div class="media">
                            <span class="me-3">
                                <i class="la la-taxi"></i>
                            </span>
                            <div class="media-body text-white text-end">
                                <p class="mb-1"><?=Yii::t("app", "Being delivered orders")?></p>
                                <h3 class="text-white"><?=number_format($being_delivered)?></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
                <div style="cursor: pointer" onclick="location.href='<?= Url::to(['/site/order', 'status' => Orders::STATUS_RETURNED])?>'" class="widget-stat card bg-danger">
                    <div class="card-body p-4">
                        <div class="media">
                            <span class="me-3">
                                <i class="la la-retweet"></i>
                            </span>
                            <div class="media-body text-white text-end">
                                <p class="mb-1"><?=Yii::t("app", "Returned orders")?></p>
                                <h3 class="text-white"><?=number_format($returned_order)?></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
                <div style="cursor: pointer" onclick="location.href='<?= Url::to(['/site/order', 'status' => Orders::STATUS_RETURNED_OPERATOR])?>'" class="widget-stat card bg-danger">
                    <div class="card-body p-4">
                        <div class="media">
                            <span class="me-3">
                                <i class="la la-retweet"></i>
                            </span>
                            <div class="media-body text-white text-end">
                                <p class="mb-1"><?=Yii::t("app", "Archive orders")?></p>
                                <h3 class="text-white"><?=number_format($archive)?></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
                <div style="cursor: pointer" onclick="location.href='<?= Url::to(['/site/order', 'status' => Orders::STATUS_READY_TO_DELIVERY])?>'" class="widget-stat card bg-primary">
                    <div class="card-body p-4">
                        <div class="media">
                            <span class="me-3">
                                <i class="la la-angle-down"></i>
                            </span>
                            <div class="media-body text-white text-end">
                                <p class="mb-1"><?=Yii::t("app", "Read to delivery orders")?></p>
                                <h3 class="text-white"><?=number_format($read_to_delivery)?></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
                <div style="cursor: pointer" onclick="location.href='<?= Url::to(['/site/order', 'status' => Orders::STATUS_THEN_TAKES])?>'" class="widget-stat card bg-white">
                    <div class="card-body  p-4">
                        <div class="media">
                            <span style="color: black; background-color: rgba(155, 145, 145, 0.25)" class="me-3">
                                <i class="la la-clock-o"></i>
                            </span>
                            <div class="media-body text-black">
                                <p class="mb-1"><?=Yii::t("app", "Then takes orders")?></p>
                                <h3 class="text-black"><?=number_format($takes_tomorrow)?></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
                <div style="cursor: pointer" onclick="location.href='<?= Url::to(['/site/order', 'status' => Orders::STATUS_HOLD])?>'" class="widget-stat card bg-warning">
                    <div class="card-body p-4">
                        <div class="media">
                            <span class="me-3">
                                <i class="la la-pause"></i>
                            </span>
                            <div class="media-body text-white">
                                <p class="mb-1"><?=Yii::t("app", "Hold orders")?></p>
                                <h3 class="text-white"><?=number_format($hold)?></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
                <div style="cursor: pointer" onclick="location.href='<?= Url::to(['/site/order', 'status' => Orders::STATUS_PREPARING])?>'" class="widget-stat card bg-secondary">
                    <div class="card-body p-4">
                        <div class="media">
                            <span class="me-3">
                                <i class="la la-edit"></i>
                            </span>
                            <div class="media-body text-white">
                                <p class="mb-1"><?=Yii::t("app", "Preparing orders")?></p>
                                <h3 class="text-white"><?=number_format($preparing)?></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
                <div style="cursor: pointer" onclick="location.href='<?= Url::to(['/site/order', 'status' => Orders::STATUS_BLACK_LIST])?>'" class="widget-stat card bg-black ">
                    <div class="card-body p-4">
                        <div class="media">
                            <span class="me-3">
                                <i class="la la-times"></i>
                            </span>
                            <div class="media-body text-white">
                                <p class="mb-1"><?=Yii::t("app", "Black list orders")?></p>
                                <h3 class="text-white"><?=number_format($black_list)?></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-xxl-6 col-lg-6 col-sm-6">
                <div style="cursor: pointer" onclick="location.href='<?= Url::to(['/site/order', 'status' => Orders::STATUS_DELIVERED])?>'" class="widget-stat card bg-success ">
                    <div class="card-body p-4">
                        <div class="media">
                            <span class="me-3">
                                <i class="la la-angle-double-down"></i>
                            </span>
                            <div class="media-body text-white">
                                <p class="mb-1"><?=Yii::t("app", "Sold orders")?></p>
                                <h3 class="text-white"><?=number_format($sold_order)?></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6 col-xxl-6 col-lg-6 col-sm-6">
                <div class="card widget-media">
                    <div class="card-header border-0 pb-0 ">
                        <h4 class="text-black"><?=Yii::t("app", "Top Selling Products")?></h4>
                    </div>
                    <div class="card-body timeline pb-2">
                        <?php foreach ($top_products as $top_product):?>
                            <div class="timeline-panel align-items-end">
                                <div class="media me-3">
                                    <img class="rounded-circle" alt="image" src="https://<?=Yii::$app->params['og_url_name']['content']?>/backend/web/uploads/product/<?=($top_product->product->photo === null || file_exists("/backend/web/uploads/product/" . $top_product->product->photo->filename)) ? "no.png" : $top_product->product->photo->filename?>" width="50">
                                </div>
                                <div class="media-body">
                                    <h5 class="mb-1"><a class="text-black" href="javascript:void(0);"><?=$top_product->product->titleTranslate?></a></h5>
                                    <p class="d-block mb-0 text-primary"><i class="las la-ticket-alt me-2 scale5 ms-1"></i>Mahsulot narxi: <?=number_format($top_product->product->sale)?> <?=Yii::t("app", "sum")?></p>
                                </div>
                                <p class="mb-0 fs-14"><?=Yii::t("app", "Payment")?> <?=number_format($top_product->product->pay)?> <?=Yii::t("app", "sum")?></p>
                            </div>
                        <?php endforeach;?>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-xxl-6 col-lg-6 col-sm-6">
                <div class="card widget-media">
                    <div class="card-header border-0 pb-0 ">
                        <h4 class="text-black"><?=Yii::t("app", "Top sellers")?></h4>
                    </div>
                    <div class="card-body timeline pb-2">
                        <?php foreach ($top_users as $top_user):?>
                            <div class="timeline-panel align-items-end">
                                <div class="media me-3">
                                    <img class="rounded-circle" alt="image" src="<?=$top_user->user->avatar?>" width="50">
                                </div>
                                <div class="media-body">
                                    <h5 class="mb-1"><a class="text-black" href="javascript:void(0);"><?=$top_user->user->fullName?></a></h5>
                                </div>
                                <p class="mb-0 fs-14"><?=Yii::t("app", "Sold orders")?> - <?=number_format($top_user->count)?></p>
                            </div>
                        <?php endforeach;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--**********************************
    Content body end
***********************************-->