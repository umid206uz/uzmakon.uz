<?php

/* @var $this yii\web\View */
/* @var $searchModel admin\models\InsertOrdersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use admin\models\InsertOrders;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use admin\widget\alert\AlertWidget;

$this->title = Yii::t("app","Insert orders");
$this->registerJs(<<<JS
$('.modalButton').click(function(){
    $('#myModal').modal('show').find('#modalContent').load($(this).attr('value'));
});
JS
    ,3)
?>
<!--**********************************
    Content body start
***********************************-->
<div class="content-body">
    <div class="container-fluid">
        <!-- row -->
        <div class="row">
            <div class="col-12">
                <?= AlertWidget::widget()?>
                <div class="card">
                    <div class="card-header">
                        <?= Html::button('<i class="fa fa-upload"></i> ' . Yii::t("app","Create new"), [
                            'id' => 'modalButton',
                            'class' => 'btn btn-success modalButton',
                            'value' => Url::to(['site/insert-modal']),
                        ]); ?>
                        <?= Html::a('<i class="fa fa-download"></i> ' . Yii::t("app", "Download Excel Template"),
                            ['site/download', 'filename' => 'shablon.xlsx'],
                            ['class' => 'btn btn-info']
                        ); ?>
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
                                    'attribute' => 'filename',
                                    'format' => 'raw',
                                    'value' => function ($model) {
                                        return Html::a($model->filename, ['site/download', 'filename' => $model->filename], [
                                            'target' => '_blank',
                                            'data-pjax' => '0'
                                        ]);
                                    },
                                ],
                                [
                                    'attribute' => 'status',
                                    'format' => 'html',
                                    'value' => function($model){
                                        return $model->statusStyle;
                                    },
                                    'filter' => Select2::widget([
                                        'model' => $searchModel,
                                        'attribute' => 'status',
                                        'data' => [
                                            InsertOrders::STATUS_NEW => Yii::t("app","New"),
                                            InsertOrders::STATUS_PREPARED => Yii::t("app","Preparing"),
                                            InsertOrders::STATUS_READY => Yii::t("app","Ready")
                                        ],
                                        'options' => ['prompt' => Yii::t("app", "Select a status")],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ]
                                    ])
                                ],
                                'inserted',
                                'double',
                                'error',
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
                                    'attribute' => 'updated_date',
                                    'value' => function($model){
                                        return Yii::$app->formatter->getDate($model->updated_date);
                                    },
                                    'filter' => DatePicker::widget([
                                        'model' => $searchModel,
                                        'attribute' => 'updated_date',
                                        'type' => DatePicker::TYPE_COMPONENT_APPEND,
                                        'pluginOptions' => [
                                            'format' => 'dd.mm.yyyy',
                                            'showMeridian' => true,
                                            'todayBtn' => true,
                                            'endDate' => '0d',
                                        ]
                                    ])
                                ],
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
<?php
Modal::begin([
    'header' => "<h4>" . Yii::t("app","Excel faylni yuklash") . "</h4>",
    'id' => "myModal",
    "size" => "modal-lg",
]);

echo "<div id='modalContent'></div>";

Modal::end();
?>