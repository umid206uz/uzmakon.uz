<?php

use common\models\AdminOrders;
use kartik\select2\Select2;
use common\models\Orders;
use common\models\Payment;
use kartik\date\DatePicker;
use kartik\grid\GridView;
use yii\web\YiiAsset;

/* @var $this yii\web\View */
/* @var $model common\models\Payment */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel common\models\AdminOrderSearch */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t("app", "Money request (admin)"), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
$balance_debt = AdminOrders::find()->where(['admin_id' => $model->user_id, 'status' => AdminOrders::STATUS_NOT_PAID, 'debit' => AdminOrders::DEBIT_DEBT])->sum('amount');
$balance_right = AdminOrders::find()->where(['admin_id' => $model->user_id, 'status' => AdminOrders::STATUS_NOT_PAID, 'debit' => AdminOrders::DEBIT_RIGHT])->sum('amount');
?>
<div class="payment-view">

    <div class="row">
        <div class="col-lg-3 col-xs-6">

            <div class="small-box bg-aqua">
                <div class="inner">
                    <h4><?=$model->user->tell . ' #ID ' . $model->user->id?></h4>
                    <p><?=$model->user->first_name . ' ' . $model->user->last_name?></p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-xs-6">

            <div class="small-box bg-green">
                <div class="inner">
                    <h4><?=Yii::$app->formatter->getPrice($balance_right - $balance_debt)?></h4>
                    <p>Admin balansi</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-xs-6">

            <div class="small-box bg-yellow">
                <div class="inner">
                    <h4><?=Yii::$app->formatter->getPrice($model->amount)?> <?=$model->statusForPayment?></h4>
                    <p>So'ralgan pul miqdori</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-xs-6">

            <div class="small-box bg-red">
                <div class="inner">
                    <h4><?=Yii::$app->formatter->getPrice(Payment::find()->where(['user_id' => $model->user_id, 'status' => 1])->sum('amount'))?></h4>
                    <p>Yechgan puli</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
            </div>
        </div>

    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'responsiveWrap' => false,
        'pager' => [
            'maxButtonCount' => 7
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'order_id',
                'format' => 'html',
                'value' => function ($model) {
                    return $model->order_id . ' ' . Orders::findOne($model->order_id)->product->title . ' ' . Yii::$app->status->statusForPayment(Orders::findOne($model->order_id)->status);
                }
            ],
            [
                'attribute' => 'amount',
                'format' => 'html',
                'value' => function ($model) {
                    return Yii::$app->formatter->getPrice($model->amount);
                }
            ],
            [
                'attribute' => 'debit',
                'format' => 'html',
                'value' => function ($model) {
                    return $model->debitForCreator;
                },
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'debit',
                    'data' => [
                        AdminOrders::DEBIT_RIGHT => Yii::t("app","Creditor"),
                        AdminOrders::DEBIT_DEBT => Yii::t("app","Debtor")
                    ],
                    'options' => ['prompt' => Yii::t("app", "Select a income type")],
                    'pluginOptions' => [
                        'allowClear' => true
                    ]
                ])
            ],
            [
                'attribute' => 'created_date',
                'format' => 'dateTime',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'created_date',
                    'type' => DatePicker::TYPE_COMPONENT_APPEND,
                    'pluginOptions' => [
                        'format' => 'dd-mm-yyyy',
                        'showMeridian' => true,
                        'todayBtn' => true,
                        'endDate' => '0d'
                    ]
                ])
            ],
            [
                'attribute' => 'payed_date',
                'format' => 'dateTime',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'payed_date',
                    'type' => DatePicker::TYPE_COMPONENT_APPEND,
                    'pluginOptions' => [
                        'format' => 'dd-mm-yyyy',
                        'showMeridian' => true,
                        'todayBtn' => true,
                        'endDate' => '0d'
                    ]
                ])
            ],
            [
                'attribute' => 'status',
                'format' => 'html',
                'value' => function ($model) {
                    return Yii::$app->status->getStatusPayment($model->status);
                },
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'status',
                    'data' => [
                        Payment::STATUS_PAID => Yii::t("app","Paid"),
                        Payment::STATUS_NOT_PAID => Yii::t("app","Not paid")
                    ],
                    'options' => ['prompt' => Yii::t("app", "Select a status")],
                    'pluginOptions' => [
                        'allowClear' => true
                    ]
                ])
            ]
        ]
    ]); ?>

</div>
