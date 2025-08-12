<?php

/* @var $model \operator\models\User */

use common\models\OperatorOrders;
use common\models\Orders;
use yii\bootstrap\ActiveForm;
use kartik\password\PasswordInput;
use yii\widgets\MaskedInput;

$this->title = Yii::t("app", "user account page");
?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <!-- BEGIN PAGE BAR -->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="/"><?=Yii::t("app", "Home")?></a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>User</span>
                </li>
            </ul>
        </div>
        <!-- END PAGE BAR -->
        <!-- BEGIN PAGE TITLE-->
        <h3 class="page-title"> <?=Yii::t("app", "New User Profile | Account")?>
            <small><?=Yii::t("app", "user account page")?></small>
        </h3>
        <!-- END PAGE TITLE-->
        <!-- END PAGE HEADER-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PROFILE SIDEBAR -->
                <div class="profile-sidebar">
                    <!-- PORTLET MAIN -->
                    <div class="portlet light profile-sidebar-portlet ">
                        <!-- SIDEBAR USERPIC -->
                        <div class="profile-userpic">
                            <img src="<?=$model->avatar?>" class="img-responsive" alt="">
                        </div>
                        <!-- END SIDEBAR USERPIC -->
                        <!-- SIDEBAR USER TITLE -->
                        <div class="profile-usertitle">
                            <div class="profile-usertitle-name"> <?=$model->first_name?> <?=$model->last_name?> </div>
                            <div class="profile-usertitle-job"> Developer </div>
                        </div>
                        <!-- END SIDEBAR USER TITLE -->
                        <!-- SIDEBAR BUTTONS -->
                        <!--                        <div class="profile-userbuttons">-->
                        <!--                            <button type="button" class="btn btn-circle green btn-sm">Follow</button>-->
                        <!--                            <button type="button" class="btn btn-circle red btn-sm">Message</button>-->
                        <!--                        </div>-->
                        <!-- END SIDEBAR BUTTONS -->
                        <!-- SIDEBAR MENU -->
                        <div class="profile-usermenu">
                            <ul class="nav">
                                <li>
                                    <a href="/">
                                        <i class="icon-home"></i> <?=Yii::t("app", "Home")?> </a>
                                </li>
                                <li class="active">
                                    <a href="#">
                                        <i class="icon-settings"></i> <?=Yii::t("app", "Balance")?> - <?=number_format(OperatorOrders::find()->where(['operator_id' => Yii::$app->user->id, 'status' => 0])->sum('amount'))?> summ  </a>
                                </li>
                            </ul>
                        </div>
                        <!-- END MENU -->
                    </div>
                    <!-- END PORTLET MAIN -->
                    <!-- PORTLET MAIN -->
                    <div class="portlet light ">
                        <!-- STAT -->
                        <div class="row list-separated profile-stat">
                            <div class="col-md-4 col-sm-4 col-xs-6">
                                <div class="uppercase profile-stat-title"> <?=count(OperatorOrders::findAll(['operator_id' => Yii::$app->user->id]))?> </div>
                                <div class="uppercase profile-stat-text"> <?=Yii::t("app", "Sold orders")?> </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-6">
                                <div class="uppercase profile-stat-title"> <?=count(Orders::findAll(['operator_id' => Yii::$app->user->id]))?> </div>
                                <div class="uppercase profile-stat-text"> <?=Yii::t("app", "Orders")?> </div>
                            </div>
                        </div>
                        <!-- END STAT -->
                        <div>
                            <h4 class="profile-desc-title">About <?=$model->first_name?> <?=$model->last_name?></h4>
                            <span class="profile-desc-text"> <?=$model->about?> </span>
                            <div class="margin-top-20 profile-desc-link">
                                <i class="fa fa-globe"></i>
                                <a href="<?=$model->url?>"><?=$model->url?></a>
                            </div>
                        </div>
                    </div>
                    <!-- END PORTLET MAIN -->
                </div>
                <!-- END BEGIN PROFILE SIDEBAR -->
                <!-- BEGIN PROFILE CONTENT -->
                <div class="profile-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="portlet light ">
                                <div class="portlet-title tabbable-line">
                                    <?php if (Yii::$app->session->hasFlash('success')): ?>

                                        <div class="alert alert-success alert-dismissable">

                                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>

                                            <?= Yii::$app->session->getFlash('success') ?>

                                        </div>

                                    <?php endif; ?>
                                    <div class="caption caption-md">
                                        <i class="icon-globe theme-font hide"></i>
                                        <span class="caption-subject font-blue-madison bold uppercase"><?=Yii::t("app", "Profile Account")?></span>
                                    </div>
                                    <ul class="nav nav-tabs">
                                        <li class="active">
                                            <a href="#tab_1_1" data-toggle="tab"><?=Yii::t("app", "Personal Info")?></a>
                                        </li>
                                        <li>
                                            <a href="#tab_1_2" data-toggle="tab"><?=Yii::t("app", "Change Avatar")?></a>
                                        </li>
                                        <li>
                                            <a href="#tab_1_3" data-toggle="tab"><?=Yii::t("app", "Change Password")?></a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="portlet-body">
                                    <div class="tab-content">
                                        <!-- PERSONAL INFO TAB -->
                                        <div class="tab-pane active" id="tab_1_1">
                                            <?php $form = ActiveForm::begin(); ?>
                                            <div class="form-group">
                                                <?= $form->field($model, 'first_name')->textInput(['placeholder' => \Yii::t("app", "First Name")]) ?>
                                            </div>
                                            <div class="form-group">
                                                <?= $form->field($model, 'last_name')->textInput(['placeholder' => \Yii::t("app", "Last Name")]) ?>
                                            </div>
                                            <div class="form-group">
                                                <?= $form->field($model, 'tell')->widget(MaskedInput::className(), [
                                                    'mask' => '+\\9\\98(99)-999-99-99',
                                                    'options' => ['placeholder' => '+998(__)-___-__-__', 'disabled' => false]
                                                ]) ?>
                                            </div>
                                            <div class="form-group">
                                                <?= $form->field($model, 'card')->widget(MaskedInput::className(), [
                                                    'mask' => '9999-9999-9999-9999',
                                                    'options' => ['placeholder' => '9999-9999-9999-9999']
                                                ]) ?>
                                            </div>
                                            <div class="form-group">
                                                <?= $form->field($model, 'occupation')->textInput(['placeholder' => \Yii::t("app", "Occupation")]) ?>
                                            </div>
                                            <div class="form-group">
                                                <?= $form->field($model, 'about')->textarea(['placeholder' => \Yii::t("app", "Briefly about yourself")]) ?>
                                            </div>
                                            <div class="form-group">
                                                <?= $form->field($model, 'url')->textInput(['placeholder' => \Yii::t("app", "http://www.mywebsite.com")]) ?>
                                            </div>
                                            <div class="margiv-top-10">
                                                <button type="submit" class="btn green"> <?=Yii::t("app", "Save Changes")?> </button>
                                            </div>
                                            <?php ActiveForm::end(); ?>
                                        </div>
                                        <!-- END PERSONAL INFO TAB -->
                                        <!-- CHANGE AVATAR TAB -->
                                        <div class="tab-pane" id="tab_1_2">
                                            <br>
                                            <?php $form = ActiveForm::begin(); ?>
                                            <div class="form-group">
                                                <div class="fileinput fileinput-new">
                                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                                    <div>
                                                        <span class="btn default btn-file">
                                                            <span class="fileinput-new"> Select image </span>
                                                            <span class="fileinput-exists"> Change </span>
                                                            <?= $form->field($model, 'picture')->fileInput()->label(false) ?>
                                                        </span>
                                                        <!--                                                            <a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"> Remove </a>-->
                                                    </div>
                                                </div>
                                                <div class="clearfix margin-top-10">
                                                    <span class="label label-danger">NOTE! </span>
                                                    <span>Attached image thumbnail is supported in Latest Firefox, Chrome, Opera, Safari and Internet Explorer 10 only </span>
                                                </div>
                                            </div>
                                            <div class="margin-top-10">
                                                <button type="submit" class="btn green"> <?=Yii::t("app", "Save Changes")?> </button>
                                            </div>
                                            <?php ActiveForm::end(); ?>
                                        </div>
                                        <!-- END CHANGE AVATAR TAB -->
                                        <!-- CHANGE PASSWORD TAB -->
                                        <div class="tab-pane <?=(Yii::$app->session->getFlash('danger')) ? "active" : ""?>" id="tab_1_3">
                                            <?php $form = ActiveForm::begin(); ?>
                                            <div class="form-group">
                                                <?= $form->field($model, 'oldpass')->widget(PasswordInput::classname(), [
                                                    'options' => [
                                                        'placeholder' => Yii::t("app", "Old Password")
                                                    ],
                                                    'pluginOptions' => [
                                                        'showMeter' => false,
                                                        'toggleMask' => true
                                                    ]
                                                ])?>
                                            </div>
                                            <div class="form-group">
                                                <?= $form->field($model, 'newpass')->widget(PasswordInput::classname(), [
                                                    'options' => [
                                                        'placeholder' => Yii::t("app", "New Password"),
                                                    ],
                                                    'pluginOptions' => [
                                                        'showMeter' => true,
                                                        'toggleMask' => true
                                                    ]
                                                ])?>
                                            </div>
                                            <div class="form-group">
                                                <?= $form->field($model, 'repeatnewpass')->widget(PasswordInput::classname(), [
                                                    'options' => [
                                                        'placeholder' => Yii::t("app", "New Password Confirm"),
                                                    ],
                                                    'pluginOptions' => [
                                                        'showMeter' => false,
                                                        'toggleMask' => true
                                                    ]
                                                ])?>
                                            </div>
                                            <div class="margin-top-10">
                                                <button type="submit" class="btn green"> <?=Yii::t("app", "Save Changes")?> </button>
                                            </div>
                                            <?php ActiveForm::end(); ?>
                                        </div>
                                        <!-- END CHANGE PASSWORD TAB -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END PROFILE CONTENT -->
            </div>
        </div>
    </div>
    <!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->