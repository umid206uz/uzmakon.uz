<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\select2\Select2;
use common\models\Regions;

/* @var $this yii\web\View */
/* @var $user common\models\User */
/* @var $searchModel common\models\OrdersPrepareSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Scan');
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs(<<<JS
let isSending = false;
$('.scan').off('keyup').on('keyup', function(){
    let text = $(this).val();
    if (text.length == 50){
        let code = text.replace("https://kuryer.uzmakon.uz/confirm/", "");
        if ((code.length == 16) && !isSending){
             isSending = true;
            $.ajax({
                url: '/backend/web/orders/cancelled',
                method: 'GET',
                data:{
                    code: code,
                },
                dataType: 'json',
                success: function (data){
                    location.reload();
                }
            });
        }
    }
    
    
    
    
});
JS
    , 3)
?>
<div class="orders-prepare-index">

    <?=Html::beginForm(['order-update'],'post', ['id' => 'submitted']);?>

    <div class="row">
        <div class="col-md-5 col-xs-6">
            <?=Select2::widget([
                'name' => 'state_2',
                'data' => Yii::$app->formatter->getEventListForScan(),
                'options' => [
                    'placeholder' => Yii::t("app", "Select a status"),
                    'required' => true
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ]
            ]);
            ?>
        </div>
        <div class="col-md-5 col-xs-6">
            <?=Select2::widget([
                'name' => 'state_3',
                'data' => Yii::$app->formatter->getCourier(),
                'options' => [
                    'placeholder' => Yii::t("app", "Select a courier"),
                ],
                'pluginOptions' => [
                    'allowClear' => true
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

    <input autofocus class="scan form-control" type="text">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'order_id',
            [
                'class' => 'yii\grid\CheckboxColumn',
                'checkboxOptions' => function($model) {
                    return ['value' => $model->order_id];
                }
            ],
            'product_name',
            'client_name',
            'client_phone',
            'admin_id',
            'operator_id',
            'courier_id',
            'region_id',
            'district_id',
            [
                'attribute' => 'order_status',
                'format' => 'raw',
                'value' => function($model){
                    return Yii::$app->status->allStatusLabel($model->order->status);
                }
            ],
            'order_date:datetime',
            'count',
            'price',
            'time:datetime'
        ],
    ]); ?>

    <?= Html::endForm();?>

</div>
