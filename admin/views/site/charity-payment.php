<?php

/* @var $this yii\web\View */
/* @var $model admin\models\Payment */
/* @var $searchModel admin\models\AdminOrdersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $count_coin integer */
/* @var $amount_coin integer */

use admin\models\CharityPayment;
use admin\widget\alert\AlertWidget;
use yii\bootstrap\ActiveForm;
use kartik\grid\GridView;
use kartik\date\DatePicker;
use kartik\select2\Select2;

$this->title = Yii::t("app", "Coin payment");
?>
<!--**********************************
    Content body start
***********************************-->
<div class="content-body">
    <div class="container-fluid">
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
                                <p class="mb-1"><?=Yii::t("app", "Amount")?></p>
                                <h4 class="mb-0"><?=Yii::$app->formatter->getPrice($amount_coin)?></h4>
                                <span class="badge badge-primary"><?=Yii::t("app", "Sum")?></span>
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
                                <p class="mb-1"><?=Yii::t("app", "Number of coins")?></p>
                                <h4 class="mb-0"><?=number_format($count_coin)?></h4>
                                <span class="badge badge-success"><?=Yii::t("app", "dona")?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-12 col-lg-12">
                <?= AlertWidget::widget()?>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><?=Yii::t("app", "Payment")?></h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <?php $form = ActiveForm::begin(); ?>
                            <div class="row">
                                <div class="mb-3 col-md-12">
                                    <?= $form->field($model, 'count')->textInput()?>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary"><?=Yii::t("app", "Send Message")?></button>
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><?=Yii::t("app", "Coin payment")?></h4>
                    </div>
                    <div class="card-body">
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'responsiveWrap' => false,
                            'pager' => [
                                'options' => [
                                    'class' => 'pagination pagination-primary'
                                ],
                                'maxButtonCount' => 6,
                                'pageCssClass' => 'page-item',
                                'nextPageCssClass' => 'page-item next',
                                'prevPageCssClass' => 'page-item prev',
                                'nextPageLabel' => '<i class="fa fa-angle-double-right"></i>',
                                'prevPageLabel' => '<i class="fa fa-angle-double-left"></i>',
                                'disabledListItemSubTagOptions' => [
                                    'tag' => 'a',
                                    'class' => 'page-link'
                                ],
                                'linkOptions' => [
                                    'class' => 'page-link'
                                ]
                            ],
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                'count',
                                [
                                    'attribute' => 'amount',
                                    'value' => function($model){
                                        return Yii::$app->formatter->getPrice($model->amount);
                                    }
                                ],
                                [
                                    'attribute' => 'created_date',
                                    'value' => function($model){
                                        return Yii::$app->formatter->getDate($model->created_date);
                                    },
                                    'filter' => DatePicker::widget([
                                        'model' => $searchModel,
                                        'attribute' => 'created_date',
                                        'type' => DatePicker::TYPE_COMPONENT_APPEND,
                                        'pluginOptions' => [
                                            'format' => 'dd.mm.yyyy',
                                            'showMeridian' => true,
                                            'todayBtn' => true,
                                            'endDate' => '0d',
                                        ]
                                    ])
                                ],
                                [
                                    'attribute' => 'payed_date',
                                    'value' => function($model){
                                        return Yii::$app->formatter->getDate($model->payed_date);
                                    },
                                    'filter' => DatePicker::widget([
                                        'model' => $searchModel,
                                        'attribute' => 'payed_date',
                                        'type' => DatePicker::TYPE_COMPONENT_APPEND,
                                        'pluginOptions' => [
                                            'format' => 'dd.mm.yyyy',
                                            'showMeridian' => true,
                                            'todayBtn' => true,
                                            'endDate' => '0d',
                                        ]
                                    ])
                                ],
                                [
                                    'attribute' => 'status',
                                    'format' => 'html',
                                    'value' => function($model){
                                        return $model->statusName;
                                    },
                                    'filter' => Select2::widget([
                                        'model' => $searchModel,
                                        'attribute' => 'status',
                                        'data' => [
                                            CharityPayment::STATUS_PAID => Yii::t("app", "Paid"),
                                            CharityPayment::STATUS_NOT_PAID => Yii::t("app", "Waiting"),
                                        ],
                                        'options' => ['prompt' => Yii::t("app", "Select a status")],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ]
                                    ])
                                ],

                            ]
                        ]); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--**********************************
    Content body end
***********************************-->