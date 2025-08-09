<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model common\models\Category */
/* @var $form yii\widgets\ActiveForm */

$this->registerJs(<<<JS
$('input#category-title').keyup(function(){
        var Text = $(this).val();
        NewText = makeSlug(Text);
    $('input#category-url').val(NewText);    
});
$('input#category-title_ru').keyup(function(){
        var Text = $(this).val();
        NewText = makeSlug(Text);
    $('input#category-url_ru').val(NewText);    
});
$('input#category-title_en').keyup(function(){
        var Text = $(this).val();
        NewText = makeSlug(Text);
    $('input#category-url_en').val(NewText);    
});
JS
    , 3)
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="col-md-12">
        <!-- Custom Tabs -->
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true"><?=Yii::t("app", "Uzbek")?></a></li>
                <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="true"><?=Yii::t("app", "Russian")?></a></li>
                <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="true"><?=Yii::t("app", "English")?></a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'meta_title')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'meta_description')->textarea(['rows' => '6']) ?>
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="tab_2">
                    <?= $form->field($model, 'title_ru')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'url_ru')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'meta_title_ru')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'meta_description_ru')->textarea(['rows' => '6']) ?>
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="tab_3">
                    <?= $form->field($model, 'title_en')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'url_en')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'meta_title_en')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'meta_description_en')->textarea(['rows' => '6']) ?>
                </div>
                <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
        </div>
        <!-- nav-tabs-custom -->
        <?= $form->field($model, 'picture')->widget(FileInput::classname(),
            [
                'options' => ['accept' => 'image/*'],
            ]);
        echo Html::error($model, 'branches', ['class' => 'error']);
        ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
