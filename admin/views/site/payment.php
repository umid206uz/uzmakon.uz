<?php

/* @var $this yii\web\View */
/* @var $model admin\models\Payment */
/* @var $searchModel admin\models\PaymentClientSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use admin\models\Payment;
use kartik\grid\GridView;
use admin\widget\alert\AlertWidget;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;

$this->title = Yii::t("app", "Withdraw money");
?>
<!--**********************************
    Content body start
***********************************-->
<div class="content-body">
    <div class="container-fluid">
        <!-- row -->
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <?= AlertWidget::widget()?>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><?=Yii::t("app", "Withdraw money")?></h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <?php $form = ActiveForm::begin(); ?>
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <?= $form->field($model, 'user_id')->textInput(['placeholder' => Yii::t("app","Credit card number"), 'value' => Yii::$app->formatter->currentUser()->card, 'disabled' => true])->label(Yii::t("app","Credit card"))?>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <?= $form->field($model, 'amount')->textInput(['placeholder' => Yii::t("app","Please enter the amount")])?>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary"><?=Yii::t("app", "Send Message")?></button>
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><?=Yii::t("app", "Payment")?></h4>
                    </div>
                    <div class="card-body">
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'responsiveWrap' => false,
                            'pager' => [
                                'options' => [
                                    'class' => 'pagination pagination-primary'
                                ],
                                'maxButtonCount' => 6,
                                'pageCssClass' => 'page-item',
                                'nextPageCssClass' => 'page-item next',
                                'prevPageCssClass' => 'page-item prev',
                                'nextPageLabel' => '<i class="fa fa-angle-double-right"></i>',
                                'prevPageLabel' => '<i class="fa fa-angle-double-left"></i>',
                                'disabledListItemSubTagOptions' => [
                                    'tag' => 'a',
                                    'class' => 'page-link'
                                ],
                                'linkOptions' => [
                                    'class' => 'page-link'
                                ]
                            ],
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                [
                                    'attribute' => 'amount',
                                    'value' => function($model){
                                        return Yii::$app->formatter->getPrice($model->amount);
                                    }
                                ],
                                [
                                    'attribute' => 'created_date',
                                    'value' => function($model){
                                        return Yii::$app->formatter->getDate($model->created_date);
                                    },
                                    'filter' => DatePicker::widget([
                                        'model' => $searchModel,
                                        'attribute' => 'created_date',
                                        'type' => DatePicker::TYPE_COMPONENT_APPEND,
                                        'pluginOptions' => [
                                            'format' => 'dd.mm.yyyy',
                                            'showMeridian' => true,
                                            'todayBtn' => true,
                                            'endDate' => '0d',
                                        ]
                                    ])
                                ],
                                [
                                    'attribute' => 'payed_date',
                                    'value' => function($model){
                                        return Yii::$app->formatter->getDate($model->payed_date);
                                    },
                                    'filter' => DatePicker::widget([
                                        'model' => $searchModel,
                                        'attribute' => 'payed_date',
                                        'type' => DatePicker::TYPE_COMPONENT_APPEND,
                                        'pluginOptions' => [
                                            'format' => 'dd.mm.yyyy',
                                            'showMeridian' => true,
                                            'todayBtn' => true,
                                            'endDate' => '0d',
                                        ]
                                    ])
                                ],
                                [
                                    'attribute' => 'status',
                                    'format' => 'html',
                                    'value' => function($model){
                                        return $model->statusForPanel;
                                    },
                                    'filter' => Select2::widget([
                                        'model' => $searchModel,
                                        'attribute' => 'status',
                                        'data' => [
                                            Payment::STATUS_PAID => Yii::t("app", "Paid"),
                                            Payment::STATUS_NOT_PAID => Yii::t("app", "Waiting"),
                                        ],
                                        'options' => ['prompt' => Yii::t("app", "Select a status")],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ]
                                    ])
                                ]
                            ]
                        ]); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--**********************************
    Content body end
***********************************-->