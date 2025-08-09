<?php

use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\select2\Select2;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel common\models\OrderLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Orders history');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-log-index">

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'responsiveWrap' => false,
        'pager' => [
            'maxButtonCount' => 8,
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'order_id',
            [
                'attribute' => 'user_id',
                'format' => 'html',
                'value' => function($model){
                    return ($model->user->first_name == '') ? $model->user->username . ' ' . $model->user->tell : $model->user->username . ' ' . $model->user->first_name . ' ' . $model->user->last_name;
                },
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'user_id',
                    'data' => $searchModel->selectUser,
                    'options' => ['prompt' => Yii::t('app', 'Select a user')],
                    'pluginOptions' => [
                        'allowClear' => true
                    ]
                ])
            ],
            [
                'attribute' => 'admin_id',
                'format' => 'html',
                'value' => function($model){
                    return ($model->admin->first_name == '') ? $model->admin->tell : $model->user->username . ' ' . $model->admin->first_name . ' ' . $model->admin->last_name;
                },
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'admin_id',
                    'data' => $searchModel->selectUser,
                    'options' => ['prompt' => Yii::t('app', 'Select a admin')],
                    'pluginOptions' => [
                        'allowClear' => true
                    ]
                ])
            ],
            [
                'attribute' => 'old_status',
                'format' => 'html',
                'value' => function($model){
                    return $model->statusOld;
                },
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'old_status',
                    'data' => Yii::$app->status->arrayStatusForAdmin(),
                    'options' => ['prompt' => Yii::t("app", "Select a status")],
                    'pluginOptions' => [
                        'allowClear' => true
                    ]
                ])
            ],
            [
                'attribute' => 'new_status',
                'format' => 'html',
                'value' => function($model){
                    return $model->statusNew;
                },
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'new_status',
                    'data' => Yii::$app->status->arrayStatusForAdmin(),
                    'options' => ['prompt' => Yii::t("app", "Select a status")],
                    'pluginOptions' => [
                        'allowClear' => true
                    ]
                ])
            ],
            [
                'attribute' => 'time',
                'format' => 'dateTime',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'time',
                    'type' => DatePicker::TYPE_COMPONENT_APPEND,
                    'pluginOptions' => [
                        'format' => 'dd-mm-yyyy',
                        'showMeridian' => true,
                        'todayBtn' => true,
                        'endDate' => '0d',
                    ]
                ]),
            ]
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
