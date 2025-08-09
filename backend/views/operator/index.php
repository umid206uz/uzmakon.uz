<?php

use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\OperatorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Operators');
$this->params['breadcrumbs'][] = $this->title;
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

            'username',
            'last_name',
            'first_name',
            [
                'attribute' => 'tell',
                'value' => function($model){
                    return Yii::$app->formatter->asPhone($model->tell);
                }
            ],
            [
                'header' => Yii::t("app", "Basic balance"),
                'value' => function($model) {
                    return Yii::$app->formatter->getPrice($model->operatorBalance);
                }
            ],
            [
                'header' => Yii::t("app", "Paid money"),
                'value' => function($model) {
                    return Yii::$app->formatter->getPrice($model->operatorPaid);
                }
            ],
            [
                'header' => Yii::t("app", "Accepted orders"),
                'value' => function($model) {
                    return $model->operatorAcceptedOrders;
                }
            ],
            [
                'header' => Yii::t("app", "Delivered orders"),
                'value' => function($model) {
                    return $model->operatorDeliveredOrders;
                }
            ],
            [
                'header' => Yii::t("app", "Returned orders"),
                'value' => function($model) {
                    return $model->operatorReturnedOrders;
                }
            ],
            [
                'header' => Yii::t("app", "Come back orders"),
                'value' => function($model) {
                    return $model->operatorComeBackOrders;
                }
            ],
            [
                'attribute' => 'operator_price',
                'value' => function($model) {
                    return Yii::$app->formatter->getPrice($model->operator_price);
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}'
            ]
        ]
    ]); ?>

</div>
