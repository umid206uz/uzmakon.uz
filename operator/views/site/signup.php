<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \common\models\LoginForm */

use yii\bootstrap\ActiveForm;

$this->title = Yii::t("app", "Sign up");
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content">
    <?php $form = ActiveForm::begin(); ?>
    <!-- BEGIN REGISTRATION FORM -->
        <h3><?=Yii::t("app", "Sign up")?></h3>
        <p> <?=Yii::t("app", "Enter your personal information below:")?> </p>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9"><?=Yii::t("app", "Username")?></label>
            <div class="input-icon">
                <?= $form->field($model, 'username')->textInput(['class' => 'form-control placeholder-no-fix', 'placeholder' => Yii::t("app", "Username")])->label(false) ?>
            </div>
        </div>
        <div class="form-group">
            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
            <label class="control-label visible-ie8 visible-ie9"><?=Yii::t("app", "Email")?></label>
            <div class="input-icon">
                <?= $form->field($model, 'email')->textInput(['class' => 'form-control placeholder-no-fix', 'placeholder' => Yii::t("app", "Mail")])->label(false) ?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9"><?=Yii::t("app", "Password")?></label>
            <div class="input-icon">
                <?= $form->field($model, 'password')->passwordInput(['class' => 'form-control placeholder-no-fix', 'placeholder' => Yii::t("app", "Password")])->label(false) ?>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" id="register-submit-btn" class="btn green pull-right"> <?=Yii::t("app", "Confirmation")?> </button>
        </div>
    <?php ActiveForm::end(); ?>
    <!-- END REGISTRATION FORM -->