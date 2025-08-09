<?php

/* @var $this yii\web\View */
/* @var $model common\models\Post */

$this->title = Yii::t("app", "Update") . ': ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t("app", "Competition"), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t("app", "Update");
?>
<div class="post-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
