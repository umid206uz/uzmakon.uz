<?php

/* @var $this yii\web\View */
/* @var $model common\models\User */

use admin\widget\alert\AlertWidget;
use yii\bootstrap\ActiveForm;
use yii\widgets\MaskedInput;

$this->title = Yii::t("app","My account");
?>
<!--**********************************
    Content body start
***********************************-->
<div class="content-body">
    <div class="container-fluid">
        <!-- row -->
        <div class="row">
            <div class="col-lg-12">
                <?= AlertWidget::widget()?>
                <div class="profile card card-body px-3 pt-3 pb-0">
                    <div class="profile-head">
                        <div class="photo-content">
                            <div class="cover-photo rounded"></div>
                        </div>
                        <div class="profile-info">
                            <div class="profile-photo">
                                <img src="<?=$model->avatar?>" class="img-fluid rounded-circle" alt="">
                            </div>
                            <div class="profile-details">
                                <div class="profile-name px-3 pt-2">
                                    <h4 class="text-primary mb-0"><?=$model->fullName?></h4>
                                    <p><?=$model->occupation?></p>
                                </div>
                                <div class="profile-email px-2 pt-2">
                                    <h4 class="text-muted mb-0"><?=$model->email?></h4>
                                    <p>Email</p>
                                </div>
                                <div class="dropdown ms-auto">
                                    <a href="#" class="btn btn-primary light sharp" data-bs-toggle="dropdown" aria-expanded="true"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg></a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li class="dropdown-item"><i class="fa fa-user-circle text-primary me-2"></i> View profile</li>
                                        <li class="dropdown-item"><i class="fa fa-users text-primary me-2"></i> Add to btn-close friends</li>
                                        <li class="dropdown-item"><i class="fa fa-plus text-primary me-2"></i> Add to group</li>
                                        <li class="dropdown-item"><i class="fa fa-ban text-primary me-2"></i> Block</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="profile-tab">
                            <div class="custom-tab-1">
                                <div class="tab-content">
                                    <div id="profile-settings" class="tab-pane fade active show">
                                        <div class="pt-3">
                                            <div class="settings-form">
                                                <h4 class="text-primary">Account Setting</h4>
                                                <?php $form = ActiveForm::begin(); ?>
                                                <div class="row">
                                                    <div class="mb-3 col-md-6">
                                                        <?= $form->field($model, 'first_name')->textInput(['placeholder' => Yii::t("app", "First Name"), 'class' => 'form-control']) ?>
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <?= $form->field($model, 'last_name')->textInput(['placeholder' => Yii::t("app", "Last Name"), 'class' => 'form-control']) ?>
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <?php if ($model->tell == '' || $model->hasErrors('tell')):?>
                                                            <?= $form->field($model, 'tell')->widget(MaskedInput::className(), [
                                                                'mask' => '+\\9\\98(99)-999-99-99',
                                                                'options' => [
                                                                    'placeholder' => '+998(__)-___-__-__',
                                                                    'class' => 'form-control'
                                                                ]
                                                            ]) ?>
                                                        <?php else:?>
                                                            <?= $form->field($model, 'tell')->widget(MaskedInput::className(), [
                                                                'mask' => '+\\9\\98(99)-999-99-99',
                                                                'options' => [
                                                                    'placeholder' => '+998(__)-___-__-__',
                                                                    'disabled' => true,
                                                                    'class' => 'form-control'
                                                                ]
                                                            ]) ?>
                                                        <?php endif;?>
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <?= $form->field($model, 'card')->widget(MaskedInput::className(), [
                                                            'mask' => '9999-9999-9999-9999',
                                                            'options' => [
                                                                'placeholder' => '9999-9999-9999-9999',
                                                                'class' => 'form-control'
                                                            ]
                                                        ]) ?>
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <?= $form->field($model, 'email')->textInput(['placeholder' => Yii::t("app", "Mail"), 'class' => 'form-control']) ?>
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <?= $form->field($model, 'username')->textInput(['placeholder' => Yii::t("app", "Username"), 'class' => 'form-control']) ?>
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <?= $form->field($model, 'access_token')->textInput(['placeholder' => Yii::t("app", "Account ID"), 'disabled' => true , 'class' => 'form-control']) ?>
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <?= $form->field($model, 'occupation')->textInput(['placeholder' => Yii::t("app", "Occupation"), 'class' => 'form-control']) ?>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <?= $form->field($model, 'about')->textarea(['placeholder' => Yii::t("app", "Briefly about yourself"), 'class' => 'form-control']) ?>
                                                </div>
                                                <button class="btn btn-primary" type="submit"><?=Yii::t("app", "Save Changes")?></button>
                                                <a href="tg://resolve?domain=UzMakonAdminBot&amp;start=<?= Yii::$app->user->id ?>" class="btn btn-primary"><?=Yii::t("app", "Bot activation")?></a>
                                                <?php ActiveForm::end(); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--**********************************
    Content body end
***********************************-->