<?php

use yii\helpers\Html;
use common\models\Product;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\touchspin\TouchSpin;
use yii\widgets\MaskedInput;
use operator\widget\alert\AlertWidget;
use yii\helpers\ArrayHelper;
use common\models\Regions;
use yii\helpers\Url;
use kartik\depdrop\DepDrop;

/* @var $this yii\web\View */
/* @var $model common\models\Orders */
/* @var $form yii\widgets\ActiveForm */

$this->title = Yii::t("app", "New order");

$this->registerJs(<<<JS
$('#orders-control_id').change(function (){
    let _this = $(this);
    let control = _this.val();
    if (control == 1){
        $('.field-orders-competition').css('display', 'block');
    }else{
        $('.field-orders-competition').css('display', 'none');
    }
});
JS
    ,3)
?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <!-- BEGIN PAGE BAR -->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="/"><?=Yii::t("app", "Home")?></a>
                </li>
            </ul>
        </div>
        <!-- END PAGE BAR -->
        <!-- BEGIN PAGE TITLE-->
        <h3 class="page-title"><?=Yii::t("app", "New order")?></h3>
        <!-- END PAGE TITLE-->
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <?= AlertWidget::widget()?>
                <div class="portlet-body">
                    <?php $form = ActiveForm::begin(); ?>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model,'product_id')->widget(Select2::classname(), [
                                'data' =>  ArrayHelper::map(Product::find()->all(), 'id', 'title'),
                                'language' => 'ru',
                                'options' => [
                                    'placeholder' => \Yii::t("app", "Select a product"),
                                    'loading' => 'disable'
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ]
                            ]);
                            ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model,'count')->widget(TouchSpin::classname(), [
                                'name' => 'volume',
                                'options' => ['placeholder' => Yii::t("app","Enter the number")],
                                'pluginOptions' => [
                                    'buttonup_class' => 'btn btn-primary',
                                    'buttondown_class' => 'btn btn-info',
                                    'buttonup_txt' => '<i class="glyphicon glyphicon-plus-sign"></i>',
                                    'buttondown_txt' => '<i class="glyphicon glyphicon-minus-sign"></i>'
                                ]
                            ]);
                            ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model,'full_name')->textInput() ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model,'phone')->widget(MaskedInput::className(), [
                                'mask' => '+\\9\\98(99)-999-99-99',
                                'options' => [
                                    'placeholder' => \Yii::t("app","Phone number")
                                ]
                            ])
                            ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'control_id')->widget(Select2::classname(), [
                                'data' => [
                                    1 => Yii::t("app","Delivery is paid"),
                                    2 => Yii::t("app","Free shipping")
                                ],
                                'language' => 'ru',
                                'options' => [
                                    'placeholder' => Yii::t("app","Select a delivery"),
                                    'value' => 1
                                ]
                            ]);?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model,'competition')->textInput(['value' => $model->competition ?: 30000])?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'region_id')->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(Regions::find()->where(['parent_id' => 1])->all(), 'code', 'name'),
                                'hideSearch' => true,
                                'language' => 'uz',
                                'options' => [
                                    'placeholder' => Yii::t("app", "Select a region"),
                                    'class' => 'form-group has-feedback'
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]); ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'district_id')->widget(DepDrop::classname(), [
                                'language' => 'ru',
                                'options' => [
                                    'placeholder' => Yii::t("app", "Select a district"),
                                    'class' => 'form-group has-feedback'
                                ],
                                'type' => DepDrop::TYPE_SELECT2,
                                'pluginOptions' => [
                                    'initialize' => true,
                                    'allowClear' => true,
                                    'depends' => ['orders-region_id'],
                                    'url' => Url::to(['/site/territorial-administrations']),
                                    'loadingText' => Yii::t("app", "Please wait!"),
                                ],
                            ])?>
                        </div>
                        <div class="col-md-12">
                            <?= $form->field($model,'addres')->textarea(['maxlength' => true]) ?>
                        </div>
                        <div class="col-md-12">
                            <?= $form->field($model,'comment')->textarea(['maxlength' => true]) ?>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <?= Html::submitButton(Yii::t("app","Submit"), ['class' => 'btn btn-success']) ?>
                            </div>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
    <!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->
