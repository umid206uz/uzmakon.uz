<?php

/* @var $model common\models\Orders */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
?>
<div class="row">
    <div class="col-md-12">
        <?php $form = ActiveForm::begin(); ?>
        <div class="col-md-12">
            <?= $form->field($model, 'status')->widget(Select2::classname(), [
                'data' => Yii::$app->status->arrayStatusForAdmin(),
                'language' => 'uz',
                'options' => [
                    'placeholder' => Yii::t("app", "Select a status"),
                    'required' => true,
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])?>

            <?= $form->field($model, 'comment')->textarea(['maxlength' => true]) ?>

            <?= $form->field($model, 'addres')->textarea(['maxlength' => true]) ?>

            <div class="form-group">
                <?= Html::submitButton(Yii::t("app", "Save Changes"), ['class' => 'btn btn-success']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>