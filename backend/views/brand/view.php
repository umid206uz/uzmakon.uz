<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Brand */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Марка', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="brand-view container box">

    <br>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [

            'name',
            'name_ru',
            'name_en',
            [
                'attribute' => 'filename',
                // 'contentOptions' =>['style'=>'width:100px'],
                'format' => 'html',
                'value' => function ($model) {
                    return '<img style="width: 150px; height: 100px" src="/backend/web/uploads/brand/'. $model->filename .'">';
                }
            ],
        ],
    ]) ?>

</div>
