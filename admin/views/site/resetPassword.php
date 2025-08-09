<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var admin\models\ResetPasswordForm $model */
/** @var common\models\Setting $setting */

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t("app","Reset password");
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="authincation h-100">
    <div class="container h-100">
        <div class="row justify-content-center h-100 align-items-center">
            <div class="col-md-6">
                <div class="authincation-content">
                    <div class="row no-gutters">
                        <div class="col-xl-12">
                            <div class="auth-form">
                                <div class="text-center mb-3">
                                    <a href="/"><img width="50%" src="https://<?=Yii::$app->params['og_url_name']['content']?>/backend/web/uploads/<?=$setting->logo?>" alt=""></a>
                                </div>
                                <h4 class="text-center mb-4"><?= Html::encode($this->title) ?></h4>
                                <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>
                                <?= $form->field($model, 'password')->passwordInput(['autofocus' => true]) ?>
                                <div class="text-center">
                                    <?= Html::submitButton(Yii::t("app","Save"), ['class' => 'btn btn-primary btn-block']) ?>
                                </div>
                                <?php ActiveForm::end(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>