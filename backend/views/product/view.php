<?php

use backend\assets\AppAsset;
use backend\widget\buttons\ButtonsWidget;
use common\models\Photos;
use yii\helpers\Html;
use yii\web\View;
use yii\web\YiiAsset;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Product */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t("app", "Products"), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
$this->registerJsFile(Yii::$app->request->BaseUrl . '/js/product.js', ['position' => View::POS_END, 'depends' => [AppAsset::className()]]);
?>
<div class="product-view">

    <p>
        <?= Html::a(Yii::t("app", "Update"), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t("app", "Delete"), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить этот элемент?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::button('<span><b class="fa fa-photo"> </b></span>', [
            'class' => 'btn btn-success modalButtonAddPicture',
            'value' => Url::to(['product/photo', 'id' => $model->id])
        ]);
        ?>
        <?= Html::button('<span><b class="fa fa-youtube-play"> </b></span>', [
            'class' => 'btn btn-danger modalButtonAddVideo',
            'value' => Url::to(['product/color', 'id' => $model->id])
        ]);
        ?>
        <?= Html::button('<span><b class="fa fa-server"> </b></span>', [
            'class' => 'btn btn-primary modalButtonDeliveryPrice',
            'value' => Url::to(['product/atrpro', 'id' => $model->id])
        ]);
        ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'category_id',
                'format' => 'html',
                'value' => function ($model) {
                    return $model->category->titleTranslate;
                }
            ],
            'title',
            [
                'attribute' => 'created_date',
                'format' => 'html',
                'value' => function ($model) {
                    return date("Y-m-d H:i:s", $model->created_date);
                }
            ],
            'title_ru',
            'title_en',
            'price',
            'sale',
            'description:ntext',
            'description_ru:ntext',
            'description_en:ntext'
        ]
    ]) ?>

</div>
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Фотографии</h3>
            </div>
            <div class="box-body">
                <?php foreach(Photos::find()->where(['product_id' => $model->id])->all() as $image):?>
                    <div class="col-sm-4" style="margin-bottom: 20px">
                        <img style="box-shadow: 9px 11px 18px #6c767b;border-radius: 10px;height: 200px; width: 300px; margin: 10px" class="img-responsive" id="<?=$image->id?>" src="/backend/web/uploads/product/<?=$image->filename?>" alt="Photo">
                        <input class="select-id" hidden type="text">
                        <?= Html::a(' <span style="width: 150px;" class="btn btn-sm btn-danger"><b class="glyphicon glyphicon-trash"></b></span>',
                            [
                                'del',
                                'id' => $image->id
                            ],
                            [
                                'data' => [
                                    'confirm' => 'Вы уверены, что хотите удалить этот элемент?',
                                    'method' => 'post',
                                ],
                                'style' => "margin-left: 10px;"
                            ]); ?>
                        <?php
                        if (Photos::findOne($image->id)->status == 1) {
                            echo Html::dropDownList('category', 'null', [
                                1=>'Active',
                                0=>'Inactive',
                            ],
                                [
                                    'class' => 'btn btn-primary dropdown-toggle select-photo',
                                    'data-id' => $image->id,
                                    'data-product_id' => $model->id,
                                    'options' => [
                                        Photos::findOne($image->id)->status => ['Selected'=>'selected'],

                                    ],
                                    'style' => "width: 150px"
                                ]);
                        }else{
                            echo Html::dropDownList('category', 'null', [
                                1=>'Active',
                                0=>'Inactive',
                            ],
                                [
                                    'class' => 'btn btn-success dropdown-toggle select-photo',
                                    'data-id' => $image->id,
                                    'data-product_id' => $model->id,
                                    'options' => [
                                        Photos::findOne($image->id)->status => ['Selected'=>'selected'],

                                    ],
                                    'style' => "width: 150px"
                                ]);
                        }
                        ?>
                    </div>
                <?php endforeach?>
                <?php if ($model->filename != ''):?>
                    <div class="col-sm-4" style="margin-bottom: 20px">
                        <video width="320" height="240" controls>
                            <source src="/backend/web/uploads/product/video/<?=$model->filename?>" type="video/mp4">
                        </video>
                    </div>
                <?php endif;?>
            </div>
        </div>
    </div>
</div>

<?= ButtonsWidget::widget()?>
