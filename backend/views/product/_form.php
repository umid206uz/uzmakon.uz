<?php

use common\models\Brand;
use common\models\Category;
use common\models\TagsPosts;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use mihaildev\ckeditor\CKEditor;
use dosamigos\selectize\SelectizeTextInput;
use kartik\switchinput\SwitchInput;

/* @var $this yii\web\View */
/* @var $model common\models\Product */
/* @var $form yii\widgets\ActiveForm */

YiiAsset::register($this);
$this->registerJs(<<<JS
$('input#product-title').keyup(function(){
        var Text = $(this).val();
        NewText = makeSlug(Text);
    $('input#product-url').val(NewText);    
});
$('input#product-title_ru').keyup(function(){
        var Text = $(this).val();
        NewText = makeSlug(Text);
    $('input#product-url_ru').val(NewText);    
});
$('input#product-title_en').keyup(function(){
        var Text = $(this).val();
        NewText = makeSlug(Text);
    $('input#product-url_en').val(NewText);    
});
JS
    , 3)
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-10">
            <?= $form->field($model, 'category_id')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(Category::find()->all(), 'id', 'title'),
                'language' => 'de',
                'options' => [
                    'placeholder' => Yii::t("app", "Select a category"),
                    'required' => true,
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'charity')->widget(SwitchInput::classname(), [
                'type' => SwitchInput::CHECKBOX
            ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'brand_id')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Brand::find()->all(), 'id', 'name'),
                        'language' => 'de',
                        'options' => [
                            'placeholder' => Yii::t("app", "Select a brand"),
                            'required' => true
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'pay')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'sale')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <label class="control-label" for="product-brand_id">Тег</label>
            <?php
            if(!$model->isNewRecord){
                $tag = ArrayHelper::map(TagsPosts::find()->where(['post_id' => $model->id])->all(), 'id', 'tag.name');
                $tag_str = implode(',' ,$tag);
            }else{
                $tag_str = '';
            }
            echo SelectizeTextInput::widget([
                'name' => 'Product[tag]',
                'loadUrl' => ['product/list'],
                'value' => $tag_str,
                'clientOptions' => [
                    'plugins' => ['remove_button'],
                    'valueField' => 'keyword',
                    'labelField' => 'keyword',
                    'searchField' => ['keyword'],
                    'create' => true,
                    'delimiter' => ',',
                    'persist' => false,
                    'createOnBlur' => true,
                    'preload' => false,
                ],
            ]);
            ?>
            <br>

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
                        <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'meta_title')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'meta_description')->textarea(['rows' => '6']) ?>
                        <?= $form->field($model, 'description')->widget(CKEditor::className(), [
                            'editorOptions' => [
                                'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                                'inline' => false, //по умолчанию false
                            ],
                        ]);
                        ?>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_2">
                        <?= $form->field($model, 'title_ru')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'url_ru')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'meta_title_ru')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'meta_description_ru')->textarea(['rows' => '6']) ?>
                        <?= $form->field($model, 'description_ru')->widget(CKEditor::className(), [
                            'editorOptions' => [
                                'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                                'inline' => false, //по умолчанию false
                            ],
                        ]);
                        ?>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_3">
                        <?= $form->field($model, 'title_en')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'url_en')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'meta_title_en')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'meta_description_en')->textarea(['rows' => '6']) ?>
                        <?= $form->field($model, 'description_en')->widget(CKEditor::className(), [
                            'editorOptions' => [
                                'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                                'inline' => false, //по умолчанию false
                            ],
                        ]);
                        ?>
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- nav-tabs-custom -->
        </div>
    </div>

    <?= $form->field($model, 'text_telegram_bot')->textarea(['rows' => 15])?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t("app", "Save"), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>