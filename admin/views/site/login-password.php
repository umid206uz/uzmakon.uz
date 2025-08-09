<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model admin\models\LoginPhoneNumberForm */
/* @var $setting common\models\Setting */

use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use admin\widget\alert\AlertWidget;

$this->title = Yii::t("app","Login with login password");
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="authincation h-100">
    <div class="container h-100">
        <div class="row justify-content-center h-100 align-items-center">
            <div class="col-md-6">
                <div class="authincation-content">
                    <div class="row no-gutters">
                        <div class="col-xl-12">
                            <?= AlertWidget::widget()?>
                            <div class="auth-form">
                                <div class="text-center mb-3">
                                    <a href="/"><img width="50%" src="https://<?=Yii::$app->params['og_url_name']['content']?>/backend/web/uploads/<?=$setting->logo?>" alt=""></a>
                                </div>
                                <h4 class="text-center mb-4"><?=Yii::t("app","Login")?></h4>
                                <?php $form = ActiveForm::begin(); ?>

                                <?= $form->field($model,'username')->textInput(['placeholder' => Yii::t("app","Username")]) ?>

                                <?= $form->field($model,'password')->passwordInput(['placeholder' => Yii::t("app","Password")]) ?>

                                <div class="form-row d-flex justify-content-between mt-4 mb-2">
                                    <div class="form-group">
                                        <div class="form-check custom-checkbox ms-1">
                                            <?= Html::activeCheckbox($model,'rememberMe', [
                                                'class' => 'form-check-input',
                                                'id' => 'basic_checkbox_1',  // Checkbox ID
                                                'label' => Html::encode(Yii::t("app","Remember me")),
                                                'labelOptions' => ['class' => 'form-check-label']
                                            ]) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary btn-block"><?=Yii::t("app","Login")?></button>
                                </div>
                                <?php ActiveForm::end(); ?>
                                <div class="new-account mt-3">
                                    <p><?=Yii::t("app","No login password?")?> <a class="text-primary" href="<?= Url::to(['/site/signup'])?>"><?=Yii::t("app","Sign up")?></a></p>
                                    <p><?=Yii::t("app","Lost your password?")?> <a class="text-primary" href="<?= Url::to(['/site/request-password-reset'])?>"><?=Yii::t("app","Password recovery")?></a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>