<?php

/* @var $model common\models\User */

use kartik\password\PasswordInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

?>
<div class="row">
    <div class="col-md-12">
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'new_pass_operator')->widget(PasswordInput::classname(), [
            'options' => [
                'placeholder' => Yii::t("app", "New Password"),
                'required' => true,
            ],
            'pluginOptions' => [
                'showMeter' => true,
                'toggleMask' => true
            ]
        ])?>
        <?= $form->field($model, 'phone_operator')->widget(MaskedInput::className(), [
            'mask' => '+\\9\\98(99)-999-99-99',
            'options' => [
                'placeholder' => '+998(__)-___-__-__',
                'required' => true,
            ]
        ])->label(Yii::t("app", "A new password will be sent to this address via SMS")) ?>
        <div class="form-group">
            <?= Html::submitButton(Yii::t("app", "Submit"), ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>