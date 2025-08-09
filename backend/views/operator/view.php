<?php

use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use simialbi\yii2\chart\widgets\PieChart;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $new_order_count integer */
/* @var $delivered_order_count integer */
/* @var $being_delivered_order_count integer */
/* @var $returned_order_count integer */
/* @var $read_to_delivery_order_count integer */
/* @var $black_list_order_count integer */
/* @var $hold_order_count integer */
/* @var $preparing_count integer */
/* @var $come_back_count integer */
/* @var $then_takes_back_count integer */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Operators'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
$this->registerJs(<<<JS
$('.modalButton').click(function(){
    $('#myModal').modal('show')
        .find('#modalContent')
        .load($(this).attr('value'));
});
$('.changePayment').click(function(){
    $('#changePayment').modal('show')
        .find('#changePayment')
        .load($(this).attr('value'));
});
JS
    , 3)
?>

<section class="content">
    <div class="row">
        <div class="col-md-3">

            <div class="box box-primary">
                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle"
                         src="<?=$model->operatorAvatar?>" alt="User profile picture">
                    <h3 class="profile-username text-center"><?=$model->fullName?></h3>
                    <p class="text-muted text-center"><?=$model->occupation?></p>
                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b><?=Yii::t("app", "Basic balance")?></b> <a class="pull-right"><?=Yii::$app->formatter->getPrice($model->operatorBalance)?></a>
                        </li>
                        <li class="list-group-item">
                            <b><?=Yii::t("app", "Paid money")?></b> <a class="pull-right"><?=Yii::$app->formatter->getPrice($model->operatorPaid)?></a>
                        </li>
                        <li class="list-group-item">
                            <b><?=Yii::t("app", "Operator price")?></b> <a class="pull-right"><?=Yii::$app->formatter->getPrice($model->operator_price)?></a>
                        </li>
                        <li class="list-group-item">
                            <b><?=Yii::t("app", "Accepted orders")?></b> <a class="pull-right"><?=$model->operatorAcceptedOrders?></a>
                        </li>
                    </ul>
                    <a href="<?= Url::to(['/operator/history-balance', 'id' => $model->id])?>" class="btn btn-primary btn-block"><b><?=Yii::t("app", "History balance")?></b></a>
                    <?= Html::button(Yii::t("app", "Change password"), [
                        'class' => 'btn btn-success btn-block modalButton',
                        'value' => Url::to(['operator/change-password', 'id' => $model->id]),
                    ]);
                    ?>
                    <?= Html::button(Yii::t("app", "Change payment"), [
                        'class' => 'btn btn-success btn-block changePayment',
                        'value' => Url::to(['operator/change-payment', 'id' => $model->id]),
                    ]);
                    ?>
                </div>

            </div>


            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?=Yii::t("app", "Information")?></h3>
                </div>

                <div class="box-body">
                    <strong><i class="fa fa-phone-square margin-r-5"></i> <?=$model->attributeLabels()['tell']?></strong>
                    <p class="text-muted">
                        <?=Yii::$app->formatter->asPhone($model->tell)?>
                    </p>
                    <hr>
                    <strong><i class="fa fa-credit-card margin-r-5"></i> <?=$model->attributeLabels()['card']?></strong>
                    <p class="text-muted"><?=$model->card?></p>
                    <hr>
                    <strong><i class="fa fa-link margin-r-5"></i> <?=$model->attributeLabels()['url']?></strong>
                    <p class="text-muted"><?=$model->url?></p>
                    <hr>
                    <strong><i class="fa fa-envelope margin-r-5"></i> <?=$model->attributeLabels()['email']?></strong>
                    <p><?=$model->email?></p>
                    <hr>
                    <strong><i class="fa fa-file-text-o margin-r-5"></i> <?=$model->attributeLabels()['about']?></strong>
                    <p><?=$model->about?></p>
                </div>

            </div>

        </div>

        <div class="col-md-9">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?=Yii::t("app", "Information")?></h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="info-box bg-aqua">
                                <span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text"><?=Yii::t("app", "New orders")?></span>
                                    <span class="info-box-number"><?=number_format($new_order_count)?></span>
                                    <div class="progress">
                                        <div class="progress-bar" style="width: <?=($new_order_count) ? $new_order_count/$model->operatorAcceptedOrders*100 : 0?>%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="info-box bg-green">
                                <span class="info-box-icon"><i class="fa fa-thumbs-o-up"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text"><?=Yii::t("app", "Delivered orders")?></span>
                                    <span class="info-box-number"><?=number_format($delivered_order_count)?></span>
                                    <div class="progress">
                                        <div class="progress-bar" style="width: <?=($delivered_order_count) ? $delivered_order_count/$model->operatorAcceptedOrders*100 : 0?>%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="info-box bg-yellow">
                                <span class="info-box-icon"><i class="fa fa-taxi"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text"><?=Yii::t("app", "Being delivered orders")?></span>
                                    <span class="info-box-number"><?=number_format($being_delivered_order_count)?></span>
                                    <div class="progress">
                                        <div class="progress-bar" style="width: <?=($being_delivered_order_count) ? $being_delivered_order_count/$model->operatorAcceptedOrders*100 : 0?>%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="info-box bg-red">
                                <span class="info-box-icon"><i class="fa fa-close"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text"><?=Yii::t("app", "Returned orders")?></span>
                                    <span class="info-box-number"><?=number_format($returned_order_count)?></span>
                                    <div class="progress">
                                        <div class="progress-bar" style="width: <?=($returned_order_count) ? $returned_order_count/$model->operatorAcceptedOrders*100 : 0?>%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="info-box bg-teal">
                                <span class="info-box-icon"><i class="fa fa-flag-o"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text"><?=Yii::t("app", "Read to delivery orders")?></span>
                                    <span class="info-box-number"><?=number_format($read_to_delivery_order_count)?></span>
                                    <div class="progress">
                                        <div class="progress-bar" style="width: <?=($read_to_delivery_order_count) ? $read_to_delivery_order_count/$model->operatorAcceptedOrders*100 : 0?>%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="info-box bg-black">
                                <span class="info-box-icon"><i class="fa fa-bell-slash"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text"><?=Yii::t("app", "Black list orders")?></span>
                                    <span class="info-box-number"><?=number_format($black_list_order_count)?></span>
                                    <div class="progress">
                                        <div class="progress-bar" style="width: <?=($black_list_order_count) ? $black_list_order_count/$model->operatorAcceptedOrders*100 : 0?>%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="info-box bg-purple">
                                <span class="info-box-icon"><i class="fa fa-external-link"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text"><?=Yii::t("app", "Hold orders")?></span>
                                    <span class="info-box-number"><?=number_format($hold_order_count)?></span>
                                    <div class="progress">
                                        <div class="progress-bar" style="width: <?=($hold_order_count) ? $hold_order_count/$model->operatorAcceptedOrders*100 : 0?>%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="info-box bg-fuchsia">
                                <span class="info-box-icon"><i class="fa fa-folder-o"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text"><?=Yii::t("app", "Preparing orders")?></span>
                                    <span class="info-box-number"><?=number_format($preparing_count)?></span>
                                    <div class="progress">
                                        <div class="progress-bar" style="width: <?=($preparing_count) ? $preparing_count/$model->operatorAcceptedOrders*100 : 0?>%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="info-box bg-maroon">
                                <span class="info-box-icon"><i class="fa fa-history"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text"><?=Yii::t("app", "Come back orders")?></span>
                                    <span class="info-box-number"><?=number_format($come_back_count)?></span>
                                    <div class="progress">
                                        <div class="progress-bar" style="width: <?=($come_back_count) ? $come_back_count/$model->operatorAcceptedOrders*100 : 0?>%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="info-box bg-olive">
                                <span class="info-box-icon"><i class="fa fa-calendar-plus-o"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text"><?=Yii::t("app", "Then takes orders")?></span>
                                    <span class="info-box-number"><?=number_format($then_takes_back_count)?></span>
                                    <div class="progress">
                                        <div class="progress-bar" style="width: <?=($then_takes_back_count) ? $then_takes_back_count/$model->operatorAcceptedOrders*100 : 0?>%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?=PieChart::widget([
                                'data' => [
                                    [
                                        'status' => Yii::t("app", "New"),
                                        'litres' => $new_order_count
                                    ],
                                    [
                                        'status' => Yii::t("app", "Read to delivery"),
                                        'litres' => $read_to_delivery_order_count
                                    ],
                                    [
                                        'status' => Yii::t("app", "Being delivered"),
                                        'litres' => $being_delivered_order_count
                                    ],
                                    [
                                        'status' => Yii::t("app", "Delivered"),
                                        'litres' => $delivered_order_count
                                    ],
                                    [
                                        'status' => Yii::t("app", "Then takes"),
                                        'litres' => $then_takes_back_count
                                    ],
                                    [
                                        'status' => Yii::t("app", "Come back orders"),
                                        'litres' => $come_back_count
                                    ],

                                    [
                                        'status' => Yii::t("app", "Returned"),
                                        'litres' => $returned_order_count
                                    ],
                                    [
                                        'status' => Yii::t("app", "Hold"),
                                        'litres' => $hold_order_count
                                    ],
                                    [
                                        'status' => Yii::t("app", "Preparing"),
                                        'litres' => $preparing_count
                                    ],
                                    [
                                        'status' => Yii::t("app", "Black list"),
                                        'litres' => $black_list_order_count
                                    ]
                                ],
                                'options' => [
                                    'style' => 'height: 300px'
                                ]
                            ]);?>
                        </div>

                    </div>
                </div>
            </div>

        </div>

    </div>

</section>

<?php
Modal::begin([
    'header' => "<h4>" . Yii::t("app", "Change password") . "</h4>",
    'id' => "myModal",
    "size" => "modal-lg",
]);

echo "<div id='modalContent'>
    
    </div>";

Modal::end();
?>

<?php
Modal::begin([
    'header' => "<h4>" . Yii::t("app", "Change payment") . "</h4>",
    'id' => "changePayment",
    "size" => "modal-lg",
]);

echo "<div id='changePayment'>
    
    </div>";

Modal::end();
?>
