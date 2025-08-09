Quantity<?php

/* @var $this yii\web\View */
/* @var $searchModel admin\models\AdminOrdersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use admin\models\AdminOrders;
use kartik\grid\GridView;
use kartik\date\DatePicker;
use kartik\select2\Select2;

$this->title = Yii::t("app","Order history");
?>
<!--**********************************
    Content body start
***********************************-->
<div class="content-body">
    <div class="container-fluid">
        <!-- row -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><?=Yii::t("app", "Order history")?></h4>
                    </div>
                    <div class="card-body">
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'responsiveWrap' => false,
                            'pager' => [
                                'maxButtonCount' => 4,
                                'options' => [
                                    'class' => 'pagination pagination-gutter'
                                ],
                                'pageCssClass' => 'page-item',
                                'nextPageCssClass' => 'page-item next',
                                'prevPageCssClass' => 'page-item prev',
                                'nextPageLabel' => '<i class="la la-angle-right"></i>',
                                'prevPageLabel' => '<i class="la la-angle-left"></i>',
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
                                [
                                    'attribute' => 'order_id',
                                    'format' => 'raw',
                                    'value' => function($model){
                                        return $model->order_id . ' ' . Yii::$app->status->statusForPanel($model->order->status);
                                    }
                                ],
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
                                            AdminOrders::STATUS_PAID => Yii::t("app", "Paid"),
                                            AdminOrders::STATUS_NOT_PAID => Yii::t("app", "Not paid"),
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
                                        return Yii::$app->formatter->getPrice($model->amount);
                                    }
                                ],
                                [
                                    'attribute' => 'debit',
                                    'format' => 'raw',
                                    'value' => function($model){
                                        return $model->debitForPanel;
                                    },
                                    'filter' => Select2::widget([
                                        'model' => $searchModel,
                                        'attribute' => 'debit',
                                        'data' => [
                                            AdminOrders::DEBIT_RIGHT => Yii::t("app", "Creditor"),
                                            AdminOrders::DEBIT_DEBT => Yii::t("app", "Debtor"),
                                        ],
                                        'options' => ['prompt' => Yii::t("app", "Select a status")],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ]
                                    ])
                                ]
                            ],
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