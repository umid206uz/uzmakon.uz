<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\touchspin\TouchSpin;
use kartik\date\DatePicker;
use yii\widgets\MaskedInput;
use kartik\depdrop\DepDrop;
use common\models\Regions;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model operator\models\UpdateForm */
/* @var $order common\models\Orders */
/* @var $form yii\widgets\ActiveForm */

$this->registerJs(<<<JS
$(document).ready(function ($){
    let status = $order->status;
    let control = $order->control_id;
    let is_then = $order->is_then;
    if (control == 1){
        $('.field-updateform-delivery_price').css('display', 'block');
    }else {
        $('.field-updateform-delivery_price').css('display', 'none');
    }
    $('.field-updateform-take_time').css('display', 'none');
    if (status == 5 || is_then == 1){
        $('.field-updateform-take_time').css('display', 'block');
    }
});
$('#updateform-status').change(function (){
    let _this = $(this);
    let status = _this.val();
    if (status == 5){
        $('.field-updateform-take_time').css('display', 'block');
    }else{
        $('.field-updateform-take_time').css('display', 'none');
    }
});
$('#updateform-control').change(function (){
    let _this = $(this);
    let control = _this.val();
    if (control == 1){
        $('.field-updateform-delivery_price').css('display', 'block');
    }else{
        $('.field-updateform-delivery_price').css('display', 'none');
    }
});

JS
    , 3)
?>

<div class="attribute-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <?php if ($order->operator_id == Yii::$app->user->id):?>
            <div class="col-md-6">
                <?= $form->field($model, 'region_id')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(Regions::find()->where(['parent_id' => 1])->all(),'code','name'),
                    'hideSearch' => true,
                    'language' => 'uz',
                    'options' => [
                        'placeholder' => Yii::t("app","Select a region"),
                        'class' => 'form-group has-feedback'
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'district_id')->widget(DepDrop::classname(), [
                    'language' => 'ru',
                    'options' => [
                        'placeholder' => Yii::t("app","Select a district"),
                        'class' => 'form-group has-feedback'
                    ],
                    'type' => DepDrop::TYPE_SELECT2,
                    'pluginOptions' => [
                        'initialize' => true,
                        'allowClear' => true,
                        'depends' => ['updateform-region_id'],
                        'url' => Url::to(['/site/territorial-administrations']),
                        'loadingText' => Yii::t("app","Please wait!"),
                    ],
                ])?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'control')->widget(Select2::classname(), [
                    'data' => [
                        1 => Yii::t("app","Delivery is paid"),
                        2 => Yii::t("app","Free shipping")
                    ],
                    'language' => 'ru',
                    'options' => ['placeholder' => Yii::t("app", "Select a delivery")]
                ]);
                ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model,'delivery_price')->textInput(['value' => $model->delivery_price ?: 30000])?>
            </div>
            <div class="col-md-12">
                <?= $form->field($model,'additional_address')->textarea(['maxlength' => true]) ?>
            </div>
            <div class="col-md-12">
                <?= $form->field($model,'comment')->textarea(['maxlength' => true]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model,'additional_phone')->widget(MaskedInput::className(), [
                    'mask' => '+\\9\\98(99)-999-99-99',
                    'options' => [
                        'placeholder' => \Yii::t("app","Additional phone number")
                    ]
                ])
                ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model,'status')->widget(Select2::classname(), [
                    'data' => Yii::$app->status->arrayStatusForOperator(),
                    'language' => 'ru',
                    'options' => ['placeholder' => Yii::t("app","Select a status")],
                    'pluginOptions' => [
                        'allowClear' => true
                    ]
                ]);
                ?>
            </div>
            <div class="col-md-12">
                <?= $form->field($model, 'take_time')->widget(DatePicker::classname(), [
                    'name' => 'check_issue_date',
                    'options' => [
                        'placeholder' => Yii::t("app", "Set the pick-up time")
                    ],
                    'pluginOptions' => [
                        'format' => 'dd.mm.yyyy',
                        'todayHighlight' => true
                    ]
                ])->label('Olish vaqti');
                ?>
            </div>
            <div class="col-md-12">
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

            <div class="col-md-12">
                <div class="form-group">
                    <?= Html::submitButton(Yii::t("app", "Submit"), ['class' => 'btn btn-success']) ?>
                </div>
            </div>
            <div class="col-md-6">
                <p><?=$order->product->descriptionTranslate?></p>
            </div>
            <div class="col-md-6">
                <h1><?=$order->product->titleTranslate?></h1>
                <h5><?=$order->product->sale?> SUMM</h5>
                <h5>Omborda <?=$order->product->in_stock ?> dona qoldi</h5>
            </div>
        <?php else:?>
            <div class="col-md-6">
                <p><?=Yii::t("app", "Order not accepted")?></p>
            </div>
        <?php endif;?>
    </div>

    <?php ActiveForm::end(); ?>

</div>