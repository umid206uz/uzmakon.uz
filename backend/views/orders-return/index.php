<?php

use kartik\select2\Select2;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use common\models\Product;
use common\models\Regions;;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel common\models\OrdersReturnSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Come back orders');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders-return-index">

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

            'id',
            'order_id',
            'new_order_id',
            [
                'attribute' => 'product_id',
                'format' => 'html',
                'value' => function($model){
                    return $model->product->title;
                },
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'product_id',
                    'data' => ArrayHelper::map(Product::find()->where(['status' => 1])->all(), 'id', 'title'),
                    'options' => ['prompt' => Yii::t('app', 'Select a product')],
                    'pluginOptions' => [
                        'allowClear' => true
                    ]
                ])
            ],
            [
                'attribute' => 'operator_id',
                'format' => 'html',
                'value' => function($model){
                    return $model->operator->username;
                },
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'operator_id',
                    'data' => Yii::$app->formatter->getOperator(),
                    'options' => ['prompt' => Yii::t('app', 'Select a operator')],
                    'pluginOptions' => [
                        'allowClear' => true
                    ]
                ])
            ],
            [
                'attribute' => 'admin_id',
                'format' => 'html',
                'value' => function($model){
                    return ($model->admin->first_name == '') ? $model->admin->tell : $model->admin->first_name . ' ' . $model->admin->last_name;
                },
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'admin_id',
                    'data' => Yii::$app->formatter->getAdminList(),
                    'options' => ['prompt' => Yii::t('app', 'Select a admin')],
                    'pluginOptions' => [
                        'allowClear' => true
                    ]
                ])
            ],
            [
                'attribute' => 'region_id',
                'value' => function($model){
                    return $model->region->name;
                },
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'region_id',
                    'data' => ArrayHelper::map(Regions::find()->where(['parent_id' => 1])->all(), 'code', 'name'),
                    'options' => ['prompt' => Yii::t("app", "Select a region")],
                    'pluginOptions' => [
                        'allowClear' => true
                    ]
                ])
            ],
            [
                'attribute' => 'district_id',
                'value' => function($model){
                    return $model->district->name;
                },
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'district_id',
                    'data' => ArrayHelper::map(Regions::find()->where(['!=', 'parent_id', 1])->all(), 'code', 'name'),
                    'options' => ['prompt' => Yii::t("app", "Select a district")],
                    'pluginOptions' => [
                        'allowClear' => true
                    ]
                ])
            ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => fn($model) => Yii::$app->status->allStatusLabel($model->status),
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'status',
                    'data' => $statusList = Yii::$app->status->arrayStatusForAdmin(),
                    'options' => ['prompt' => Yii::t("app", "Select a status")],
                    'pluginOptions' => [
                        'allowClear' => true
                    ]
                ])
            ],
            [
                'attribute' => 'order_date',
                'format' => 'dateTime',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'order_date',
                    'type' => DatePicker::TYPE_COMPONENT_APPEND,
                    'pluginOptions' => [
                        'format' => 'dd-mm-yyyy',
                        'showMeridian' => true,
                        'todayBtn' => true,
                        'endDate' => '0d',
                    ]
                ]),
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
                        'endDate' => '0d',
                    ]
                ]),
            ],
            'customer_name',
            'customer_phone',
            'address',
            'comment',
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
