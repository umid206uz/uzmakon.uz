<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model admin\models\LoginPhoneNumberForm */
/* @var $setting common\models\Setting */

use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use admin\widget\alert\AlertWidget;
use yii\widgets\MaskedInput;

$this->title = Yii::t("app","Login");
?>
<div class="authincation h-100">
    <div class="container h-100">
        <div class="row justify-content-center h-100 align-items-center">
            <div class="col-md-6">
                <div class="authincation-content">
                    <div class="row no-gutters">
                        <div class="col-xl-12">
                            <?= AlertWidget::widget()?>
                            <?php if (Yii::$app->session->get('step') === 'verify'): ?>
                                <div class="auth-form">
                                    <div class="text-center mb-3">
                                        <a href="/"><img width="50%" src="https://<?=Yii::$app->params['og_url_name']['content']?>/backend/web/uploads/<?=$setting->logo?>" alt=""></a>
                                    </div>
                                    <h4 class="text-center mb-4"><?=Yii::$app->session->get('phone_number')?> <?=Yii::t("app","Enter the OTP code sent to")?></h4>
                                    <?php $form = ActiveForm::begin(['id' => 'verify-code-form']); ?>
                                    <?= Html::hiddenInput('LoginPhoneNumberForm[phone_number]', Yii::$app->session->get('phone_number')) ?>
                                    <?= $form->field($model,'verification_code')->textInput(['placeholder' => Yii::t("app","Code")]);?>
                                    <div class="text-center">
                                        <?= Html::submitButton(Yii::t("app","Login"), ['class' => 'btn btn-primary btn-block', 'name' => 'action', 'value' => 'login-button']) ?>
                                    </div>
                                    <?php ActiveForm::end(); ?>
                                    <div class="new-account mt-3">
                                        <p><?=Yii::t("app", "Don't received the OTP?")?> <a class="text-primary" href="<?= Url::to(['reset-verification-code'])?>"><?=Yii::t("app", "Send back sms")?></a></p>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="auth-form">
                                    <div class="text-center mb-3">
                                        <a href="/"><img width="50%" src="https://<?=Yii::$app->params['og_url_name']['content']?>/backend/web/uploads/<?=$setting->logo?>" alt=""></a>
                                    </div>
                                    <h4 class="text-center mb-4"><?=Yii::t("app", "To Keep connected with us please login with your personal info.")?></h4>
                                    <?php $form = ActiveForm::begin(['id' => 'send-phone-form']); ?>
                                    <?= $form->field($model, 'phone_number')->widget(MaskedInput::className(), [
                                        'mask' => '+\\9\\98(99)-999-99-99',
                                        'options' => [
                                            'placeholder' => '+998(__)-___-__-__',
                                            'class' => 'floating-input form-control'
                                        ]
                                    ]);?>
                                    <div class="text-center">
                                        <?= Html::submitButton(Yii::t("app","Login"), ['class' => 'btn btn-primary btn-block', 'name' => 'action', 'value' => 'send-code-button']) ?>
                                    </div>
                                    <?php ActiveForm::end(); ?>
                                    <div class="new-account mt-3">
                                        <p><?=Yii::t("app", "Don't have a phone number?")?> <a class="text-primary" href="<?= Url::to(['login-password'])?>"><?=Yii::t("app", "Login with login password")?></a></p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
