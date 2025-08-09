<?php

use kartik\grid\GridView;
use simialbi\yii2\chart\widgets\PieChart;
use kartik\switchinput\SwitchInput;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $new common\models\Orders */
/* @var $read_to_delivery common\models\Orders */
/* @var $returned_operator common\models\Orders */
/* @var $being_delivered common\models\Orders */
/* @var $delivered common\models\Orders */
/* @var $black_list common\models\Orders */
/* @var $returned common\models\Orders */
/* @var $takes_tomorrow common\models\Orders */
/* @var $today_new common\models\Orders */
/* @var $today_read_to_delivery common\models\Orders */
/* @var $today_returned_operator common\models\Orders */
/* @var $today_being_delivered common\models\Orders */
/* @var $today_delivered common\models\Orders */
/* @var $today_black_list common\models\Orders */
/* @var $today_returned common\models\Orders */
/* @var $today_takes_tomorrow common\models\Orders */
/* @var $paid common\models\AdminOrders */
/* @var $not_paid common\models\AdminOrders */
/* @var $operator_paid common\models\OperatorOrders */
/* @var $operator_not_paid common\models\OperatorOrders */
/* @var $data common\models\Orders */
/* @var $daily_data common\models\Orders */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::$app->params['og_site_name']['content'];
$js = <<< JS
    function sendRequest(status, id){
        $.ajax({
            url:'/backend/web/setting/update-status',
            method:'post',
            data:{status:status,id:id},
            success:function(data){
                alert('Successfully');
            },
            error:function(jqXhr,status,error){
                alert(error);
            }
        });
    }
JS;

$this->registerJs($js, View::POS_READY);
?>
<div class="row">
    <div class="col-md-12">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                [
                    'attribute' => 'switch',
//                    'contentOptions' =>['style'=>'width:10px'],
                    'format' => 'raw',
                    'value' => function ($model) {
                        return SwitchInput::widget(
                            [
                                'name' => 'status',
                                'pluginEvents' => [
                                    'switchChange.bootstrapSwitch' => "function(e){sendRequest($model->switch, $model->id);}"
                                ],

                                'pluginOptions' => [
                                    'size' => 'mini',
                                    'onColor' => 'success',
                                    'offColor' => 'danger',
                                    'onText' => Yii::t('app', 'Active'),
                                    'offText' => Yii::t('app', 'Inactive')
                                ],
                                'value' => $model->switch
                            ]
                        );
                    }
                ],
            ],
        ]); ?>
    </div>
    <div class="col-md-6">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Barcha buyurtmalar viloyatlar kesimida:</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <?php if ($data):?>
                <?=PieChart::widget([
                    'data' => $data,
                    'options' => [
                        'style' => 'height: 300px'
                    ]
                ]);?>
                <?php endif;?>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
    <div class="col-md-6">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Barcha buyurtmalar holati bo'yicha:</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <?=PieChart::widget([
                    'data' => [
                        [
                            'status' => Yii::t("app", "New"),
                            'litres' => $new
                        ],
                        [
                            'status' => Yii::t("app", "Read to delivery"),
                            'litres' => $read_to_delivery
                        ],
                        [
                            'status' => Yii::t("app", "Being delivered"),
                            'litres' => $being_delivered
                        ],
                        [
                            'status' => Yii::t("app", "Delivered"),
                            'litres' => $delivered
                        ],
                        [
                            'status' => Yii::t("app", "Then takes"),
                            'litres' => $takes_tomorrow
                        ],
                        [
                            'status' => Yii::t("app", "Returned"),
                            'litres' => $returned
                        ],

                        [
                            'status' => Yii::t("app", "Returned operator"),
                            'litres' => $returned_operator
                        ],
                        [
                            'status' => Yii::t("app", "Black list"),
                            'litres' => $black_list
                        ]
                    ],
                    'options' => [
                        'style' => 'height: 300px'
                    ]
                ]);?>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
    <div class="col-md-6">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Bugungi buyurtmalar viloyatlar kesimida:</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <?php if(!empty($daily_data)):?>
                    <?=PieChart::widget([
                        'data' => $daily_data,
                        'options' => [
                            'style' => 'height: 300px'
                        ]
                    ]);?>
                <?php endif;?>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
    <div class="col-md-6">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Bugungi buyurtmalar holati bo'yicha:</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <?=PieChart::widget([
                    'data' => [
                        [
                            'status' => Yii::t("app", "New"),
                            'litres' => $today_new
                        ],
                        [
                            'status' => Yii::t("app", "Read to delivery"),
                            'litres' => $today_read_to_delivery
                        ],
                        [
                            'status' => Yii::t("app", "Being delivered"),
                            'litres' => $today_being_delivered
                        ],
                        [
                            'status' => Yii::t("app", "Delivered"),
                            'litres' => $today_delivered
                        ],
                        [
                            'status' => Yii::t("app", "Then takes"),
                            'litres' => $today_takes_tomorrow
                        ],
                        [
                            'status' => Yii::t("app", "Returned"),
                            'litres' => $today_returned
                        ],

                        [
                            'status' => Yii::t("app", "Returned operator"),
                            'litres' => $today_returned_operator
                        ],
                        [
                            'status' => Yii::t("app", "Black list"),
                            'litres' => $today_black_list
                        ]
                    ],
                    'options' => [
                        'style' => 'height: 300px'
                    ]
                ]);?>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
    <div class="col-md-6">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Admin balansi hisobi:</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <?=PieChart::widget([
                    'data' => [
                        [
                            'status' => Yii::t("app", "Paid"),
                            'litres' => $paid
                        ],
                        [
                            'status' => Yii::t("app", "Not paid"),
                            'litres' => $not_paid
                        ]
                    ],
                    'options' => [
                        'style' => 'height: 300px'
                    ]
                ]);?>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
    <div class="col-md-6">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">Operator balansi hisobi:</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <?=PieChart::widget([
                    'data' => [
                        [
                            'status' => Yii::t("app", "Paid"),
                            'litres' => $operator_paid
                        ],
                        [
                            'status' => Yii::t("app", "Not paid"),
                            'litres' => $operator_not_paid
                        ]
                    ],
                    'options' => [
                        'style' => 'height: 300px'
                    ]
                ]);?>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
</div>