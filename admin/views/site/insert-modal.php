<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model admin\models\InsertOrders */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="videos-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model,'excel')->widget(FileInput::classname(), [
            'options' => [
                    'accept' => '.xls, .xlsx',
                    'required' => true
            ],
        ])->label(false);
    ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t("app", "Save"), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>