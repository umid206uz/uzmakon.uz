<?php
/** @var array $attrs */
/** @var object $model */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="delivery_forms">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'tashkent_city')->textInput(); ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'tashkent_region')->textInput(); ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'bukhara')->textInput(); ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'navoi')->textInput(); ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'samarkand')->textInput(); ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'jizzakh')->textInput(); ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'andijan')->textInput(); ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'fergana')->textInput(); ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'namangan')->textInput(); ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'syrdarya')->textInput(); ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'karakalpakstan')->textInput(); ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'khorezm')->textInput(); ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'kashkadarya')->textInput(); ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'surkhandarya')->textInput(); ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t("app", "Save"), ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>