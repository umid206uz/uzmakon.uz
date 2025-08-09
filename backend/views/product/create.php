<?php

/* @var $this yii\web\View */
/* @var $model common\models\Product */

$this->title = Yii::t("app", "Create new");
$this->params['breadcrumbs'][] = ['label' => Yii::t("app", "Products"), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
