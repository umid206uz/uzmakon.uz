<?php

/* @var $this yii\web\View */
/* @var $new_model common\models\OperatorPayment */
/* @var $searchModel common\models\OperatorPaymentClientSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use common\models\OperatorOrders;
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\select2\Select2;
use kartik\date\DatePicker;

$this->title = Yii::t("app", "Order history");
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
                    <a href="<?= Url::to(['/'])?>"><?=Yii::t("app", "Home")?></a>
                    <i class="fa fa-circle"></i>
                </li>
                <li><?=Yii::t("app", "Order history")?></li>
            </ul>
        </div>
        <!-- END PAGE BAR -->
        <h3 class="page-title"><?=Yii::t("app", "Order history")?></h3>
        <!-- END PAGE HEADER-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <i class="icon-settings font-dark"></i>
                            <span class="caption-subject bold uppercase"><?=Yii::t("app", "Order history")?></span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'responsiveWrap' => false,
                            'pager' => [
                                'maxButtonCount' => 4
                            ],
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                'order_id',
                                [
                                    'header' => Yii::t("app", "Product name"),
                                    'value' => function($model){
                                        return $model->order->product->titleTranslate;
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
                                            'format' => 'dd-mm-yyyy',
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
                                            'format' => 'dd-mm-yyyy',
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
                                        return $model->statusForPanel;
                                    },
                                    'filter' => Select2::widget([
                                        'model' => $searchModel,
                                        'attribute' => 'status',
                                        'data' => [
                                            OperatorOrders::STATUS_PAID => Yii::t("app", "Paid"),
                                            OperatorOrders::STATUS_NOT_PAID => Yii::t("app", "Not paid"),
                                        ],
                                        'options' => ['prompt' => Yii::t("app", "Select a status")],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ]
                                    ])
                                ],
                                [
                                    'attribute' => 'amount',
                                    'format' => 'html',
                                    'value' => function($model){
                                        return Yii::$app->formatter->getPrice($model->amount) . ' ' . $model->debitForPanel;
                                    }
                                ],
                                [
                                    'header' => Yii::t("app", "Order status"),
                                    'format' => 'html',
                                    'value' => function($model){
                                        return Yii::$app->status->statusForPanel($model->order->status);
                                    }
                                ]
                            ]
                        ]); ?>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
    </div>
    <!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->