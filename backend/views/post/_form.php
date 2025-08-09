<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use kartik\file\FileInput;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">

        <div class="col-md-4">
            <?= $form->field($model, 'gold')->textInput() ?>
        </div>

        <div class="col-md-4">
            <?= $form->field($model, 'started_date')->widget(DatePicker::classname(), [
                'name' => 'check_issue_date',
                'value' => date('yyyy-mm-dd', strtotime('+2 days')),
                'options' => ['placeholder' => 'Select issue date ...'],
                'pluginOptions' => [
                    'format' => 'yyyy-mm-dd',
                    'todayHighlight' => true
                ]
            ]);
            ?>
        </div>

        <div class="col-md-4">
            <?= $form->field($model, 'closed_date')->widget(DatePicker::classname(), [
                'name' => 'check_issue_date',
                'value' => date('yyyy-mm-dd', strtotime('+2 days')),
                'options' => ['placeholder' => 'Select issue date ...'],
                'pluginOptions' => [
                    'format' => 'yyyy-mm-dd',
                    'todayHighlight' => true
                ]
            ]);
            ?>
        </div>

        <div class="col-md-12">
            <?= $form->field($model, 'picture')->widget(FileInput::classname(), [
                'options' => ['accept' => 'image/*'],
            ]);
            echo Html::error($model, 'picture', ['class' => 'error']);
            ?>
        </div>
    </div>

    <!-- Custom Tabs -->
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_1" data-toggle="tab"><?=Yii::t("app", "Uzbek")?></a></li>
            <li><a href="#tab_2" data-toggle="tab"><?=Yii::t("app", "Russian")?></a></li>
            <li><a href="#tab_3" data-toggle="tab"><?=Yii::t("app", "English")?></a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
                <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'description')->widget(CKEditor::className(), [
                    'editorOptions' => [
                        'preset' => 'full',
                        'inline' => false
                    ],
                ]);
                ?>
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="tab_2">
                <?= $form->field($model, 'title_ru')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'description_ru')->widget(CKEditor::className(), [
                    'editorOptions' => [
                        'preset' => 'full',
                        'inline' => false
                    ]
                ]);
                ?>
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="tab_3">
                <?= $form->field($model, 'title_en')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'description_en')->widget(CKEditor::className(), [
                    'editorOptions' => [
                        'preset' => 'full',
                        'inline' => false
                    ]
                ]);
                ?>
            </div>
            <!-- /.tab-pane -->
        </div>
        <!-- /.tab-content -->
    </div>
    <!-- nav-tabs-custom -->

    <div class="form-group">
        <?= Html::submitButton(Yii::t("app", "Save"), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
