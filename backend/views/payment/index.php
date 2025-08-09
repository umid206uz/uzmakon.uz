<?php

use kartik\date\DatePicker;
use kartik\grid\GridView;
use kartik\select2\Select2;
use kartik\editable\Editable;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PaymentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t("app", "Money request (admin)");
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs(<<<JS
$(document).on('pjax:complete', function(event) {
        location.reload();
});
JS
    , 3)
?>
<div class="payment-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'responsiveWrap' => false,
        'pager' => [
            'maxButtonCount' => 8,
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'user_id',
                'format' => 'html',
                'value' => function($model){
                    return ($model->user->first_name == '') ? $model->user->tell : $model->user->first_name . ' ' . $model->user->last_name . ' ' . $model->user->tell;
                },
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'user_id',
                    'data' => Yii::$app->formatter->getAdminList(),
                    'options' => ['prompt' => Yii::t('app', 'Select a admin')],
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
                'header' => Yii::t("app", "Credit card number"),
                'format' => 'html',
                'value' => function ($model) {
                    return $model->user->card;
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
                'class' => 'kartik\grid\EditableColumn',
                'header' => Yii::t("app", "Status"),
                'attribute' => 'status',
                'value' => function($model){
                    return $model->status;
                },
                'editableOptions' => [
                    'header' => 'Payment',
                    'inputType' => Editable::INPUT_DROPDOWN_LIST,
                    'data' => Yii::$app->formatter->getSelectStatusForPayment(),
                    'options' => ['class'=>'form-control', 'prompt' => Yii::t("app", "Select a status")],
                    'displayValueConfig'=> [
                        '1' => '<i class="fa fa-thumbs-o-up"></i> ' . Yii::t("app", "Paid"),
                        '0' => '<i class="fa fa-flag"></i> ' . Yii::t("app", "Waiting"),
                    ],
                ],
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'status',
                    'data' => Yii::$app->formatter->getSelectStatusForPayment(),
                    'options' => ['prompt' => Yii::t("app", "Select a status")],
                    'pluginOptions' => [
                        'allowClear' => true
                    ]
                ])
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}'
            ]
        ]
    ]); ?>

</div>
