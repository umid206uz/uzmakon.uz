<?php

use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\OperatorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model common\models\User */

$this->title = Yii::t('app','History balance');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Operators'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t("app", "History balance");
?>
<div class="user-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'responsiveWrap' => false,
        'pjax' => true,
        'pager' => [
            'maxButtonCount' => 8
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'order_id',
                'format' => 'html',
                'value' => function ($model) {
                    return $model->order_id . ' ' . $model->order->product->title . ' ' . Yii::$app->status->statusForPayment($model->order->status);
                }
            ],
            [
                'attribute' => 'amount',
                'format' => 'html',
                'value' => function ($model) {
                    return Yii::$app->formatter->getPrice($model->amount) . ' ' . $model->debitForCreator;
                }
            ],
            [
                'attribute' => 'created_date',
                'format' => 'html',
                'value' => function ($model) {
                    return Yii::$app->formatter->getDate($model->created_date);
                }
            ],
            [
                'attribute' => 'payed_date',
                'format' => 'html',
                'value' => function ($model) {
                    return Yii::$app->formatter->getDate($model->payed_date);
                }
            ],
            [
                'attribute' => 'status',
                'format' => 'html',
                'value' => function ($model) {
                    return $model->statusForPayment;
                }
            ]
        ]
    ]); ?>

</div>
