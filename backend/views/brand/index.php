<?php



use yii\helpers\Html;

use kartik\grid\GridView;

use yii\bootstrap\Modal;



/* @var $this yii\web\View */

/* @var $searchModel common\models\BrandSearch */

/* @var $dataProvider yii\data\ActiveDataProvider */



$this->title = 'Марка';

$this->params['breadcrumbs'][] = $this->title;

$this->registerJs(<<<JS

$('.modalButton').click(function(){

    $('#myModal').modal('show')

        .find('#modalContent')

        .load($(this).attr('value'));

});

JS

, 3)

?>

<div class="brand-index container box">



    <br>



    <p>

        <?= Html::a('Создать', ['create'], ['class' => 'btn btn-success']) ?>

    </p>



    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>



    <?= GridView::widget([

        'dataProvider' => $dataProvider,

        'filterModel' => $searchModel,

        'columns' => [

            ['class' => 'yii\grid\SerialColumn'],


            [
                'attribute' => 'filename',
                // 'contentOptions' =>['style'=>'width:100px'],
                'format' => 'html',
                'value' => function ($model) {
                    return '<img style="width: 75px; height: 50px" src="/backend/web/uploads/brand/'. $model->filename .'">';
                }
            ],
            'name',

            'name_ru',

            'name_en',
	    [
                'class' => 'kartik\grid\EditableColumn',
                'header' => 'Status',
                'attribute' => 'status',
                'value' => function($model){
                    return $model->status;
                },
                'editableOptions' => [
                    'header' => 'Category',
                    'inputType' => kartik\editable\Editable::INPUT_DROPDOWN_LIST,
                    'data' => [0 => 'Inactive', 1 => 'Active'],
                    'options' => ['class'=>'form-control', 'prompt'=>'Select status...'],
                    'displayValueConfig'=> [
                        '0' => '<i class="fa fa-thumbs-o-down"></i> Inactive',
                        '1' => '<i class="fa fa-thumbs-o-up"></i> Active',
                    ],
                ], 
            ],


            [

                'class' => 'yii\grid\ActionColumn',

                'template' => '{view}',

                'contentOptions' =>['style'=>'width:10px'],



                'buttons' => 

                ['view' => function($url, $model) 

                {

                    return Html::button('<span><b style="height: 67px" class="fa fa-photo"> </b></span>', [

                        'id' => 'modalButton',

                        'class' => 'btn btn-primary modalButton',

                        'value' => yii\helpers\Url::to(['brand/modal', 'id' => $model->id]),

                    ]);

                },

                ]

            ],
['attribute'=>'Dow',
           'contentOptions' => ['style' => 'width:30px'],
        'format'=>'raw',
        'value' => function($model)
        {
        return
        Html::a('<b style="height: 67px" class="glyphicon glyphicon-download"></b>', ['brand/download', 'id' => $model->id],['class' => 'btn btn-primary']);

        }
        ],


            ['class' => 'yii\grid\ActionColumn'],

        ],

    ]); ?>





</div>

<?php

    Modal::begin([

        'header' => "<h4>Присоединять width=186px</h4>",

        'id' => "myModal",

        "size" => "modal-lg",

    ]);



    echo "<div id='modalContent'>

    

    </div>";



    Modal::end();

?>