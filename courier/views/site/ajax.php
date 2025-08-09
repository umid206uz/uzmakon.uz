<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model courier\models\UpdateForm */
/* @var $order common\models\Orders */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="attribute-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'status')->widget(Select2::classname(), [
                'data' => $model->getStatus(),
                'language' => 'ru',
                'options' => ['placeholder' => Yii::t("app", "Select a status")],
                'pluginOptions' => [
                    'allowClear' => true
                ]
            ])?>
        </div>
        <div class="col-md-12">
            <?= $form->field($model, 'comment')->textarea(['maxlength' => true]) ?>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <?= Html::submitButton(Yii::t("app", "Submit"), ['class' => 'btn btn-success']) ?>
            </div>
        </div>
        <div class="col-md-6">
            <h1><?=$order->product->titleTranslate?></h1>
            <h5><?=$order->product->sale?> SUMM</h5>
            <h5>Omborda <?=$order->product->in_stock ?> dona qoldi</h5>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
