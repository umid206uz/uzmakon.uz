<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\switchinput\SwitchInput;
/* @var $this yii\web\View */
/* @var $searchModel common\models\SliderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Sliders');
$this->params['breadcrumbs'][] = $this->title;
$js = <<< JS
    function sendRequest(status, id){
        $.ajax({
            url:'/backend/web/site/update',
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

$this->registerJs($js, \yii\web\View::POS_READY);
?>
<div class="slider-index container box">

    <br>

    <p>
        <?= Html::a(Yii::t('app', 'Create Slider'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'pjax' => true,
        'export' => false,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'contentOptions' =>['style'=>'width:10px'],
            ],

            'title',
            
            //'description_ru',
            //'description_en',
            //'button',
            //'button_ru',
            //'button_en',
            //'filename',
            //'url:url',
            [
                'attribute' => 'filename',
                'contentOptions' =>['style'=>'width:100px'],
                'format' => 'html',
                'value' => function ($model) {
                    return '<img style="width: 250px; height: 100px" src="/backend/web/uploads/slider/'. $model->filename .'">';
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' =>['style'=>'width:10px'],
                
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
