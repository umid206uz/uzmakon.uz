<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model common\models\Slider */
/* @var $form yii\widgets\ActiveForm */
$data = [
    1 => 'Slider',
    2 => 'Slider bottom banner',
    3 => 'Main banner',
    4 => 'Main mini banner',
]
?>

<div class="slider-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php if(empty($model->filename)):?>
        <?= $form->field($model, 'picture')->widget(FileInput::classname(), 
            [
                'options' => ['accept' => 'image/*'],
            ]); 
            echo Html::error($model, 'picture', ['class' => 'error']);
        ?>
    <?php else:?>
        <?= $form->field($model, 'picture')->widget(FileInput::classname(), 
            [
                'options' => ['accept' => 'image/*'],
                'pluginOptions' => [
                    'initialPreview'=>[
                        "/backend/web/uploads/slider/". $model->filename,
                    ],
                    'showRemove' => false,
                    'initialPreviewAsData'=>true,
                    'initialCaption'=> $model->filename,
                    'overwriteInitial'=>false,
                    'maxFileSize'=>2800
                ]
            ]); 
            echo Html::error($model, 'picture', ['class' => 'error']);
        ?>
    <?php endif;?>

    <div class="row">
        <div class="col-md-12">
            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">узбекиский</a></li>
                <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="true">русский</a></li>
                <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="true">английский</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'button')->textInput(['maxlength' => true]) ?>
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="tab_2">
                    <?= $form->field($model, 'title_ru')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'description_ru')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'button_ru')->textInput(['maxlength' => true]) ?>
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="tab_3">
                    <?= $form->field($model, 'title_en')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'description_en')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'button_en')->textInput(['maxlength' => true]) ?>
                </div>
                <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
            </div>
            <!-- nav-tabs-custom -->
        </div>
    </div>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'status')->widget(Select2::classname(), [
            'data' => $data,
            //'disabled' => true,
            'language' => 'de',
            'options' => ['placeholder' => 'Select a Category ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
