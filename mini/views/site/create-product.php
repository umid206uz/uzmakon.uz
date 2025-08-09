<?php

use common\models\Product;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\touchspin\TouchSpin;
use yii\helpers\Html;
use yii\helpers\Url;
use dominus77\sweetalert2\Alert;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model common\models\AdditionalProduct */
/* @var $order common\models\Orders */
/* @var $form yii\widgets\ActiveForm */

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
                    <a href="<?= Url::to(['/'])?>"><?=Yii::t("app", "Home")?></a>
                    <i class="fa fa-circle"></i>
                </li>
                <li><?=Yii::t("app", "New order")?></li>
            </ul>
        </div>
        <!-- END PAGE BAR -->
        <h3 class="page-title"><?=Yii::t("app", "New order")?></h3>
        <!-- END PAGE HEADER-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet light bordered">
                    <?php if (Yii::$app->session->hasFlash('success')): ?>
                    <?= Alert::widget([
                        'options' => [
                            'title' => Yii::$app->session->getFlash('success'),
                            'icon' => 'success',
                            'showCancelButton' => true,
                            'showConfirmButton' => false,
                            'cancelButtonText' => 'Yopish',
                            'cancelButtonColor' => '#3085d6',
                        ],
                        'callback' => new JsExpression("
                        function(result) {
                            if (result.dismiss === Swal.DismissReason.cancel) {
                                window.location.href = '" . Url::to(['site/index']) . "';
                            }
                        }
                    "),
                    ]);?>
                    <?php endif; ?>
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
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <?= Html::submitButton(Yii::t("app", "Submit"), ['class' => 'btn btn-success']) ?>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
    </div>
    <!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->