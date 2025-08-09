<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model common\models\Photos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="photos-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'photos[]')->widget(FileInput::classname(),
        [
            'options' =>
                [
                    'accept' => 'image/*',
                    'multiple' => true
                ],
        ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t("app", "Save"), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
