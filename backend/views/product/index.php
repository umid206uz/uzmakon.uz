<?php

use backend\assets\AppAsset;
use common\models\Category;
use kartik\select2\Select2;
use backend\widget\buttons\ButtonsWidget;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t("app", "Products");
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile(Yii::$app->request->BaseUrl . '/js/product.js', ['position' => View::POS_END, 'depends' => [AppAsset::className()]]);
?>
<div class="product-index">

    <p>
        <?= Html::a(Yii::t("app", "Create new"), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t("app", "Dostafkaga tayyor mahsulotlar"), ['orders/daily-product'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'pjax' => true,
        'filterModel' => $searchModel,
        'responsiveWrap' => false,
        'pager' => [
            'maxButtonCount' => 8
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'category_id',
                'format' => 'html',
                'value' => 'category.title',
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'category_id',
                    'data' => ArrayHelper::map(Category::find()->asArray()->all(), 'id', 'title'),
                    'options' => ['prompt' => Yii::t('app', 'Select a category')],
                    'pluginOptions' => [
                        'allowClear' => true
                    ]
                ])
            ],
            'title',
            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'price',
                'value' => function($model){
                    return $model->price;
                }
            ],
            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'in_stock',
                'value' => function($model){
                    return $model->in_stock;
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'contentOptions' =>['style'=>'width:10px'],
                'buttons' => [
                    'view' => function($url, $model) {
                        return Html::button('<span><b class="fa fa-server"> </b></span>', [
                            'class' => 'btn btn-success modalButtonDeliveryPrice',
                            'value' => Url::to(['product/atrpro', 'id' => $model->id])
                        ]);
                    }
                ]
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'contentOptions' => ['style'=>'width:10px'],
                'buttons' => [
                    'view' => function($url, $model) {
                        return Html::button('<span><b class="fa fa-photo"> </b></span>', [
                            'class' => 'btn btn-primary modalButtonAddPicture',
                            'value' => Url::to(['product/photo', 'id' => $model->id])
                        ]);
                    }
                ]
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'contentOptions' =>['style'=>'width:10px'],
                'buttons' => [
                    'view' => function($url, $model) {
                        return Html::button('<span><b class="fa fa-youtube-play"> </b></span>', [
                            'class' => 'btn btn-primary modalButtonAddVideo',
                            'style' => 'background-color: #ff0000; border-color: #ff0000',
                            'value' => Url::to(['product/color', 'id' => $model->id])
                        ]);
                    }
                ]
            ],
            ['class' => 'yii\grid\ActionColumn']
        ]
    ]); ?>

</div>

<?= ButtonsWidget::widget()?>
