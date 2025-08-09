<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var admin\models\PasswordResetRequestForm $model */
/** @var common\models\Setting $setting */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use admin\widget\alert\AlertWidget;

$this->title = Yii::t("app","Request password reset");
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
                                <h4 class="text-center mb-4"><?= Html::encode($this->title) ?></h4>
                                <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>
                                <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>
                                <div class="text-center">
                                    <?= Html::submitButton(Yii::t("app","Send"), ['class' => 'btn btn-primary btn-block']) ?>
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
