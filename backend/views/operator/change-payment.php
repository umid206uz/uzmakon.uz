<?php

/* @var $model common\models\User */

use kartik\password\PasswordInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="row">
    <div class="col-md-12">
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'operator_price')->textInput(['required' => true])?>
        <div class="form-group">
            <?= Html::submitButton(Yii::t("app", "Submit"), ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>