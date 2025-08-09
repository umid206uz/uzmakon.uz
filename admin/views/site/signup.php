<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model admin\models\SignupForm */
/* @var $setting common\models\Setting */

use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use admin\widget\alert\AlertWidget;


$this->title = Yii::t("app","Register");
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
                                <h4 class="text-center mb-4"><?=Yii::t("app","Register")?></h4>
                                <?php $form = ActiveForm::begin(); ?>

                                <?= $form->field($model, 'username')->textInput(['placeholder' => Yii::t("app","Username")]) ?>

                                <?= $form->field($model, 'email')->textInput(['placeholder' => Yii::t("app","Mail")]) ?>

                                <?= $form->field($model, 'password')->passwordInput(['placeholder' => Yii::t("app","Password")]) ?>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary btn-block"><?=Yii::t("app","Register")?></button>
                                </div>
                                <?php ActiveForm::end(); ?>
                                <div class="new-account mt-3">
                                    <p><?=Yii::t("app","Already have an account?")?> <a class="text-primary" href="<?= Url::to(['/site/login'])?>"><?=Yii::t("app","Login")?></a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>