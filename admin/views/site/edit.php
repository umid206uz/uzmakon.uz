<?php

/* @var $this yii\web\View */
/* @var $model common\models\User */

use frontend\widget\alert\AlertWidget;
use yii\bootstrap\ActiveForm;
use kartik\switchinput\SwitchInput;

$this->title = Yii::t("app", "Telegram bot configuration");
?>
<!--**********************************
    Content body start
***********************************-->
<div class="content-body">
    <div class="container-fluid">
        <!-- row -->
        <div class="row">
            <div class="col-xl-12">
                <?= AlertWidget::widget()?>
                <div class="card">
                    <div class="card-body">
                        <div class="profile-tab">
                            <div class="custom-tab-1">
                                <div class="tab-content">
                                    <div id="profile-settings" class="tab-pane fade active show">
                                        <div class="pt-3">
                                            <div class="settings-form">
                                                <h4 class="text-primary"><?=Yii::t("app", "Telegram bot configuration")?></h4>
                                                <?php $form = ActiveForm::begin(); ?>
                                                <div class="row">
                                                    <div class="mb-3 col-md-2">
                                                        <?= $form->field($model, 'status_new')->widget(SwitchInput::classname(), []);?>
                                                    </div>
                                                    <div class="mb-3 col-md-2">
                                                        <?= $form->field($model, 'status_being_delivered')->widget(SwitchInput::classname(), []);?>
                                                    </div>
                                                    <div class="mb-3 col-md-2">
                                                        <?= $form->field($model, 'status_delivered')->widget(SwitchInput::classname(), []);?>
                                                    </div>
                                                    <div class="mb-3 col-md-2">
                                                        <?= $form->field($model, 'status_returned')->widget(SwitchInput::classname(), []);?>
                                                    </div>
                                                    <div class="mb-3 col-md-2">
                                                        <?= $form->field($model, 'status_black_list')->widget(SwitchInput::classname(), []);?>
                                                    </div>
                                                    <div class="mb-3 col-md-2">
                                                        <?= $form->field($model, 'status_then_takes')->widget(SwitchInput::classname(), []);?>
                                                    </div>
                                                    <div class="mb-3 col-md-2">
                                                        <?= $form->field($model, 'status_ready_to_delivery')->widget(SwitchInput::classname(), []);?>
                                                    </div>
                                                    <div class="mb-3 col-md-2">
                                                        <?= $form->field($model, 'status_hold')->widget(SwitchInput::classname(), []);?>
                                                    </div>
                                                    <div class="mb-3 col-md-2">
                                                        <?= $form->field($model, 'status_preparing')->widget(SwitchInput::classname(), []);?>
                                                    </div>
                                                </div>
                                                <button class="btn btn-primary" type="submit"><?=Yii::t("app", "Save Changes")?></button>
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