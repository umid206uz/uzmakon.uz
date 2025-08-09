<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t("app", "Categories");
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <p>
        <?= Html::a(Yii::t("app", "Create new"), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'responsiveWrap' => false,
        'pjax' => true,
        'export' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'title',
            'title_ru',
            'title_en',
            [
                'attribute' => 'filename',
                'contentOptions' =>['style'=>'width:40px'],
                'format' => 'html',
                'value' => function ($model) {
                    return '<img style="width: 40px; height: 40px" src="/backend/web/uploads/category/'. $model->filename .'">';
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' =>['style'=>'width:10px'],
            ],
        ],
    ]); ?>

</div>
