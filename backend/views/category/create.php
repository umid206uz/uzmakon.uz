<?php

/* @var $this yii\web\View */
/* @var $model common\models\Category */

$this->title = Yii::t("app", "Create new");
$this->params['breadcrumbs'][] = ['label' => Yii::t("app", "Categories"), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
