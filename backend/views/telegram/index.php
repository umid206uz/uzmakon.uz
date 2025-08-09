<?php

use kartik\grid\GridView;
use yii\web\View;
use yii\widgets\Pjax;
use kartik\switchinput\SwitchInput;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TelegramSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Telegram bot configuration');
$this->params['breadcrumbs'][] = $this->title;
$js = <<< JS
    function sendRequest(status, id){
        $.ajax({
            url:'/backend/web/telegram/update-status',
            method:'post',
            data:{status:status,id:id},
            success:function(data){
                Command: toastr["success"]("O'zgartirildi")
                toastr.options = {
                  "closeButton": false,
                  "debug": false,
                  "newestOnTop": false,
                  "progressBar": false,
                  "positionClass": "toast-top-right",
                  "preventDuplicates": false,
                  "onclick": null,
                  "showDuration": "300",
                  "hideDuration": "1000",
                  "timeOut": "5000",
                  "extendedTimeOut": "1000",
                  "showEasing": "swing",
                  "hideEasing": "linear",
                  "showMethod": "fadeIn",
                  "hideMethod": "fadeOut"
                }
            },
            error:function(jqXhr,status,error){
                alert(error);
            }
        });
    }
JS;

$this->registerJs($js, View::POS_READY);
?>
<div class="telegram-index">

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

            'full_name',
            'user_chat_id',
            [
                'attribute' => 'status',
                'label' => Yii::t("app", "Status"),
                'contentOptions' => ['style'=>'width:10px'],
                'format' => 'raw',
                'value' => function ($model) {
                    return SwitchInput::widget(
                        [
                            'name' => 'status',
                            'pluginEvents' => [
                                'switchChange.bootstrapSwitch' => "function(e){sendRequest($model->status, $model->id);}"
                            ],

                            'pluginOptions' => [
                                'size' => 'mini',
                                'onColor' => 'success',
                                'offColor' => 'danger',
                                'onText' => Yii::t("app", "Active"),
                                'offText' => Yii::t("app", "Inactive")
                            ],
                            'value' => $model->status
                        ]
                    );
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}'
            ]
        ]
    ]) ?>

    <?php Pjax::end(); ?>

</div>
