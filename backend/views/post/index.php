<?php

use kartik\grid\GridView;
use kartik\editable\Editable;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t("app", "Competition");
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'responsiveWrap' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'title',
            'title_ru',
            'title_en',
            'started_date',
            'closed_date',
            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'status',
                'value' => function($model){
                    return $model->status;
                },
                'editableOptions' => [
                    'inputType' => Editable::INPUT_DROPDOWN_LIST,
                    'data' => [
                        0 => Yii::t("app", "Inactive"),
                        1 => Yii::t("app", "Active")
                    ],
                    'displayValueConfig'=> [
                        0 => '<i class="fa fa-thumbs-o-down"></i> ' . Yii::t("app", "Inactive"),
                        1 => '<i class="fa fa-thumbs-o-up"></i> ' . Yii::t("app", "Active"),
                    ]
                ]
            ],
            [
                'attribute' => 'filename',
                'contentOptions' =>['style'=>'width:100px'],
                'format' => 'html',
                'value' => function ($model) {
                    return '<img style="width: 150px; height: 100px" src="/backend/web/uploads/post/'. $model->filename .'">';
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}'
            ]
        ]
    ]); ?>

</div>
