<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = Yii::t("app", "Login");
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- BEGIN LOGIN -->
<div class="content">
    <!-- BEGIN LOGIN FORM -->
    <?php $form = ActiveForm::begin(); ?>
    <h3 class="form-title"><?=Yii::t("app", "Login")?></h3>
    <div class="alert alert-danger display-hide">
        <button class="close" data-close="alert"></button>
        <span> Enter any username and password. </span>
    </div>
    <div class="form-group">
        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
        <label class="control-label visible-ie8 visible-ie9">Username</label>
        <div class="input-icon">
            <?= $form->field($model, 'username')->textInput(['class' => 'form-control placeholder-no-fix', 'placeholder' => 'Loginni kiriting'])->label(false) ?>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label visible-ie8 visible-ie9">Password</label>
        <div class="input-icon">
            <?= $form->field($model, 'password')->passwordInput(['class' => 'form-control placeholder-no-fix', 'placeholder' => 'Parolni kiriting'])->label(false) ?>
        </div>
        <div class="form-actions">
            <label class="rememberme mt-checkbox mt-checkbox-outline">
                <input type="checkbox" name="remember" value="1" /> <?=Yii::t("app", "Remember me")?>
                <span></span>
            </label>
            <button type="submit" class="btn green pull-right"> <?=Yii::t("app", "Login")?> </button>
        </div>
        <div class="create-account">
            <p> Sizda hali profil yo'qmi ?&nbsp;
                <a href="<?= Url::to(['site/signup'])?>"> <?=Yii::t("app", "Sign up")?> </a>
            </p>
        </div>
        <?php ActiveForm::end(); ?>
        <!-- END LOGIN FORM -->
    </div>
    <!-- END LOGIN -->