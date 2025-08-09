<?php

use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Post */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t("app", "Competition"), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>
<div class="post-view">

    <p>
        <?= Html::a(Yii::t("app", "Update"), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'category_id',
                'format' => 'html',
                'value' => function ($model) {
                    return $model->category->name;
                }
            ],
            'title',
            'title_ru',
            'title_en',
            'gold',
            [
                'attribute' => 'started_date',
                'format' => 'html',
                'value' => function ($model) {
                    return $model->started_date;
                }
            ],
            [
                'attribute' => 'closed_date',
                'format' => 'html',
                'value' => function ($model) {
                    return $model->closed_date;
                }
            ],
            [
                'attribute' => 'posted_by',
                'format' => 'html',
                'value' => function ($model) {
                    return $model->user->username;
                }
            ],
            [
                'attribute' => 'status',
                'format' => 'html',
                'value' => function ($model) {
                    if($model->status == 0){
                        return 'Inactive';
                    }else{
                        return 'Active';
                    }
                }
            ],
            'description:ntext',
            'description_ru:ntext',
            'description_en:ntext',
            [
                'attribute' => 'filename',
                'format' => 'html',
                'value' => function ($model) {
                    return '<img style="width: 150px; height: 100px" src="/backend/web/uploads/post/'. $model->filename .'">';
                }
            ],
        ],
    ]) ?>

</div>
