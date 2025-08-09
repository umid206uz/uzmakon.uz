<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

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
                    <a href="<?= Url::to(['/'])?>">Asosiy</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    Pul yechish
                </li>
            </ul>
        </div>
        <!-- END PAGE BAR -->
        <h3 class="page-title"> Pul yechish
            <small></small>
        </h3>
        <!-- END PAGE HEADER-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <i class="icon-settings font-dark"></i>
                            <span class="caption-subject bold uppercase"> Pul yechish</span>
                        </div>
                    </div>
                    <?php if (Yii::$app->session->hasFlash('success')): ?>

                        <div class="alert alert-success alert-dismissable">

                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>

                            <?= Yii::$app->session->getFlash('success') ?>

                        </div>

                    <?php endif; ?>
                    <?php $form = ActiveForm::begin([
                        'fieldConfig' => [
                            'options' => [
                                'tag'=>false
                            ]
                        ],
                    ]); ?>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Plastik kartasi</label>
                                <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="icon-credit-card"></i>
                                </span>
                                    <?= $form->field($models, 'operator_id', ['options' => ['tag' => false]])->textInput(['placeholder' => \Yii::t("app","Karta raqami"), 'value' => $models->operator->card, 'disabled' => true])->label(false)?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Yechiladigan pul miqdori</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="icon-credit-card"></i>
                                    </span>
                                    <?= $form->field($models, 'amount', ['options' => ['tag' => false]])->textInput(['placeholder' => \Yii::t("app","pul miqdorini kiriting")])->label(false)?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Yuborish</label>
                                <div class="input-group">
                                    <button type="submit" class="btn green">Yuborish</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                            <thead>
                            <tr>
                                <th>
                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                        <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" />
                                        <span></span>
                                    </label>
                                </th>
                                <th> Sana </th>
                                <th> Hisob raqami </th>
                                <th> Summa </th>
                                <th> Holat </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($model as $item):?>
                                <tr class="odd gradeX <?=($item->status == 1) ? "success" : "danger"?>">
                                    <td>
                                        <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                            <input type="checkbox" class="checkboxes" value="1" />
                                            <span></span>
                                        </label>
                                    </td>
                                    <td> <?=date("j F, Y");?></td>
                                    <td>
                                        <?= $item->operator->card?>
                                    </td>
                                    <td>
                                        <?= number_format($item->amount) ?>
                                    </td>
                                    <td class="center"> <?= $item->status1?> </td>
                                </tr>
                            <?php endforeach?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
    </div>
    <!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->