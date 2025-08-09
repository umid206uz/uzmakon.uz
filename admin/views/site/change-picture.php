<?php

/* @var $this yii\web\View */
/* @var $model common\models\User */

use kartik\file\FileInput;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use kartik\password\PasswordInput;

$this->title = Yii::t("app", "Change picture");
?>
<!-- Main container starts -->
<div class="container-fluid main-container pt-0" id="main-container">
    <div class="row">
        <div class="position-relative w-100 h-320">
            <div class="background">
                <img src="/frontend/web/dashboard/img/background-part.png" alt="">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="container">
            <div class="row top-100">
                <div class="col-12 col-md-4 col-lg-3 pb-4">
                    <div class="row">
                        <div class="col-12 text-center">
                            <figure class="avatar avatar-180 rounded-circle shadow  mx-auto">
                                <img style="width: 75%" src="<?=$model->avatar?>" alt="">
                            </figure>
                        </div>
                    </div>
                </div>
                <div class="col my-3">
                    <h4 class="text-white"><?=$model->fullName?></h4>
                    <p class="text-mute text-white"><?=Yii::t("app", "Working as")?>: <?=$model->occupation?>
                    </p>
                </div>
                <div class="col-auto my-3">
                    <button class="btn btn-sm btn-outline-primary"><i class="material-icons md-18 mr-2">person_add</i> Friend</button>
                    <button class="btn btn-sm btn-primary ml-2"><i class="material-icons md-18 mr-2">add</i> Follow</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-4 col-lg-3">
                    <div class="card mb-4 shadow-sm border-0">
                        <div class="card-body text-left">
                            <div class="page-subtitle">Your Details</div>
                            <ul class="nav nav-pills nav-fill flex-column sidemenu">
                                <li class="nav-item">
                                    <a class="nav-link text-left" href="<?= Url::to(['/site/account'])?>"><?=Yii::t("app", "Your Personal Details")?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-left" href="<?= Url::to(['/site/edit'])?>"><?=Yii::t("app", "Telegram bot configuration")?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-left" href="<?= Url::to(['/site/change-password'])?>"><?=Yii::t("app", "Change password")?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-left active" href="<?= Url::to(['/site/change-picture'])?>"><?=Yii::t("app", "Change picture")?></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <?php if (Yii::$app->session->hasFlash('success')): ?>
                        <div class="alert alert-success" role="alert">
                            <?= Yii::$app->session->getFlash('success') ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                    <?php endif; ?>
                    <div class="card mb-4 shadow-sm border-0">
                        <?php $form = ActiveForm::begin(); ?>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <?= $form->field($model, 'picture')->widget(FileInput::classname(),
                                            [
                                                'options' => ['accept' => 'image/*'],
                                            ])->label(false);
                                        echo Html::error($model, 'branches', ['class' => 'error']);
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary float-right"><?=Yii::t("app", "Save Changes")?></button>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- Main container ends -->