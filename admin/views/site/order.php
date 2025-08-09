<?php

/* @var $this yii\web\View */
/* @var $status integer */
/* @var $searchModel admin\models\AdminOrdersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use kartik\grid\GridView;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use \yii\helpers\ArrayHelper;
use common\models\Regions;

$title = Yii::$app->status->allStatusTranslate($status);

$this->title = $title;
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
                        <h4 class="card-title"><?=$title?></h4>
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
                                'id',
                                [
                                    'attribute' => 'text',
                                    'value' => function($model){
                                        return Yii::$app->formatter->getDate($model->text);
                                    },
                                    'filter' => DatePicker::widget([
                                        'model' => $searchModel,
                                        'attribute' => 'text',
                                        'type' => DatePicker::TYPE_COMPONENT_APPEND,
                                        'pluginOptions' => [
                                            'format' => 'dd-mm-yyyy',
                                            'showMeridian' => true,
                                            'todayBtn' => true,
                                            'endDate' => '0d',
                                        ]
                                    ])
                                ],
                                'full_name',
                                [
                                    'attribute' => 'phone',
                                    'value' => function($model){
                                        $model->phone = strtr($model->phone, [
                                            '+998' => '',
                                            '-' => '',
                                            '(' => '',
                                            ')' => '',
                                            ' ' => ''
                                        ]);
                                        return str_replace(substr("$model->phone", -7,3), '***', $model->phone);
                                    }
                                ],
                                [
                                    'attribute' => 'region_id',
                                    'value' => function($model){
                                        return $model->region->name;
                                    },
                                    'filter' => Select2::widget([
                                        'model' => $searchModel,
                                        'attribute' => 'region_id',
                                        'data' => ArrayHelper::map(Regions::find()->where(['parent_id' => 1])->all(),'code','name'),
                                        'options' => ['prompt' => Yii::t("app","Select a region")],
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
                                        'data' => ArrayHelper::map(Regions::find()->where(['!=', 'parent_id', 1])->all(),'code','name'),
                                        'options' => ['prompt' => Yii::t("app","Select a district")],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ]
                                    ])
                                ],
                                [
                                    'attribute' => 'product_id',
                                    'value' => function($model){
                                        return $model->product->titleTranslate;
                                    }
                                ],
                                [
                                    'attribute' => 'oqim_id',
                                    'value' => function($model){
                                        return $model->oqim->title;
                                    }
                                ],
                                [
                                    'attribute' => 'status',
                                    'format' => 'html',
                                    'value' => function($model){
                                        return Yii::$app->status->statusForPanel($model->status) . '<br>' . date("d.m.Y H:i:s", ($model->lastMovedDate) ? $model->lastMovedDate->time : $model->text);
                                    },
                                    'filter' => Select2::widget([
                                        'model' => $searchModel,
                                        'attribute' => 'status',
                                        'data' => Yii::$app->status->arrayStatusForAdmin(),
                                        'options' => ['prompt' => Yii::t("app", "Select a status")],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ]
                                    ]),
                                ],
                                [
                                    'header' => Yii::t("app", "The last practice"),
                                    'value' => function($model){
                                        return $model->time_elapsed_string(date("d.m.Y H:i:s", ($model->lastMovedDate) ? $model->lastMovedDate->time : $model->text), false);;
                                    }
                                ],
                                'comment',
                                'addres'
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