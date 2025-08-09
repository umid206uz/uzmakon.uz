<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model common\models\Photos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="videos-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'picture')->widget(FileInput::classname(),
        [
            'options' =>
                [
                    'accept' => '*',
                ],
        ])->label(false);
    ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t("app", "Save"), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>