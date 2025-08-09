<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TagsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tags';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tags-index container box">

    <br>

    <p>
        <?= Html::a('Create Tags', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'contentOptions' =>['style'=>'width:10px'],
            ],
            'name',
            [
                'attribute' => 'status',
                'format' => 'html',
                'contentOptions' =>['style'=>'width:80px'],
                'value' => function ($model) {
                    if($model->status == 1){
                        return "<span class='label label-success'>Active</span>";
                    }else{
                        return "<span class='label label-danger'>Inactive</span>";
                    }
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' =>['style'=>'width:10px'],
            ],        ],
    ]); ?>


</div>
