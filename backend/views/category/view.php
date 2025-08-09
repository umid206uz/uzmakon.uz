<?php

use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Category */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t("app", "Categories"), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>
<div class="category-view">

    <p>
        <?= Html::a(Yii::t("app", "Update"), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t("app", "Delete"), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить этот элемент?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [

            'title',
            'title_ru',
            'title_en',
            'url',
            'url_ru',
            'url_en',
            'meta_title',
            'meta_title_ru',
            'meta_title_en',
            'meta_description',
            'meta_description_ru',
            'meta_description_en',
            [
                'attribute' => 'filename',
                'contentOptions' =>['style'=>'width:50%'],
                'format' => 'html',
                'value' => function ($model) {
                    return '<img style="width: 100px; height: 100px" src="/backend/web/uploads/category/'. $model->filename .'">';
                }
            ]
        ],
    ]) ?>

</div>
