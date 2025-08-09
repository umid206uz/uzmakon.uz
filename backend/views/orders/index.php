<?php

use common\models\Regions;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use yii\bootstrap\Modal;
use common\models\PdfForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\OrdersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t("app", "Orders");
$this->params['breadcrumbs'][] = $this->title;
$pdf = new PdfForm();
$data = [
    1 => 'Faqat chek chiqarish holati "Tayyorlanmoqda" ga o\'tadi',
    6 => 'Faqat QR code chiqarish holati "Yetkazilmoqda" ga o\'tadi',
    5 => 'QR code va chek chiqarish holati "Yetkazilmoqda" ga o\'tadi',
    2 => 'Qaytarildi',
    3 => 'Yetkazildi',
    4 => 'Yangi',
];
$this->registerJs(<<<JS
$(document).on('pjax:complete', function(event) {
        location.reload();
});
$('.modalButton').click(function(){
    $('#myModal').modal('show')
        .find('#modalContent')
        .load($(this).attr('value'));
});
$( ".selected" ).click(function() {
    if (confirm('Ishonchingiz komilmi? Siz tanlagan buyurtmalar holati o`zgartiriladi'))
    {
        return true;
    }else
    {
        return  false   
    }
});
JS
    , 3)
?>
    <div class="orders-index">

        <?=Html::beginForm(['pdf-action'],'post', ['id' => 'submitted']);?>

        <div class="row">
            <div class="col-md-10 col-xs-8">
                <?=Select2::widget([
                    'name' => 'state_2',
                    'value' => '',
                    'data' => $data,
                    'options' => [
                        'placeholder' => Yii::t("app", "Select a status"),
                        'style' => ['width' => 200],
                        'required' => true
                    ]
                ]);
                ?>
            </div>
            <div class="col-md-2 col-xs-4">
                <div class="form-group">
                    <?=Html::submitButton('Export PDF', ['class' => 'btn btn-primary selected']);?>
                </div>
            </div>
        </div>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'layout'=>'{summary}'.Html::activeDropDownList($searchModel, 'myPageSize', [20 => 20, 50 => 50, 100 => 100, 1000 => 1000],['id'=>'myPageSize', 'class' => 'form-control', 'style' => 'width: 6%'])."{items}<br/>{pager}",
            'filterModel' => $searchModel,
            'responsiveWrap' => false,
            'filterSelector' => '#myPageSize',
            'pager' => [
                'maxButtonCount' => 8,
            ],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'id',
                [
                    'attribute' => 'product_id',
                    'value' => 'product.title'
                ],
                [
                    'header' => 'Narxi',
                    'attribute' => 'price',
                    'value' => 'product.sale'
                ],
                [
                    'class' => 'yii\grid\CheckboxColumn',
                    'checkboxOptions' => function($model) {
                        return ['value' => $model->id];
                    }
                ],
                [
                    'attribute' => 'user_id',
                    'format' => 'html',
                    'value' => function($model){
                        return ($model->user->first_name == '') ? $model->user->tell : $model->user->first_name . ' ' . $model->user->last_name;
                    },
                    'filter' => Select2::widget([
                        'model' => $searchModel,
                        'attribute' => 'user_id',
                        'data' => $searchModel->getSelectUser(),
                        'options' => ['prompt' => Yii::t('app', 'Select a admin')],
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
                        'data' => $searchModel->getSelectOperator(),
                        'options' => ['prompt' => Yii::t('app', 'Select a operator')],
                        'pluginOptions' => [
                            'allowClear' => true
                        ]
                    ])
                ],
                'full_name',
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
                'phone',
                [
                    'attribute' => 'text',
                    'format' => 'dateTime',
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
                    ]),
                ],
                [
                    'attribute' => 'delivery_time',
                    'format' => 'dateTime',
                    'filter' => DatePicker::widget([
                        'model' => $searchModel,
                        'attribute' => 'delivery_time',
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
                    'attribute' => 'take_time',
                    'format' => 'dateTime',
                    'filter' => DatePicker::widget([
                        'model' => $searchModel,
                        'attribute' => 'take_time',
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
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view}',
                    'contentOptions' =>['style'=>'width:10px'],
                    'buttons' =>
                        ['view' => function($url, $model)
                        {
                            return Html::button('<span><b class="fa fa-arrows"> </b></span>', [
                                'id' => 'modalButton',
                                'class' => 'btn btn-primary modalButton',
                                'value' => Url::to(['orders/status', 'id' => $model->id]),
                            ]);
                        },
                        ]
                ],
                [
                    'attribute' => 'status',
                    'format' => 'raw',
                    'value' => function($model){
                        return Yii::$app->status->statusForPayment($model->status);
                    },
                    'filter' => Select2::widget([
                        'model' => $searchModel,
                        'attribute' => 'status',
                        'data' => Yii::$app->status->arrayStatusForAdmin(),
                        'options' => ['prompt' => Yii::t("app","Select a status")],
                        'pluginOptions' => [
                            'allowClear' => true
                        ]
                    ])
                ],
                'comment',
                'addres',
//                'control_id',
//                'competition',
            ],
        ]); ?>

        <?= Html::endForm();?>
    </div>

<?php
Modal::begin([
    'header' => "<h4>Statusni o'zgartirish</h4>",
    'id' => "myModal",
    "size" => "modal-lg",
]);

echo "<div id='modalContent'></div>";

Modal::end();
?>