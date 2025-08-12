<?php

/* @var $this yii\web\View */
/* @var $pagination yii\data\Pagination */
/* @var $counts common\models\OrdersReturn */
/* @var $model common\models\OrdersReturn */
/* @var $item common\models\OrdersReturn */

use operator\widget\alert\AlertWidget;
use operator\widget\count\CountWidget;
use yii\widgets\LinkPager;
use yii\bootstrap\Modal;
use operator\widget\returned\OrderReturnWidget;

$this->title = Yii::t("app", "New orders");
$this->registerJs(<<<JS
$('.orders').click(function(){
    let order_id = $(this).data('order_id');
    let _this = $(this);
    let _phone_id = $('#phone_id_' + order_id);
    $(_this).find('i').removeClass('fa-check').addClass('fa-spinner fa-spin');
    $(_this).prop('disabled', true);
    $.ajax({
        url: '/returned/order-ajax',
        method: 'GET',
        data:{
            order_id: order_id,
        },
        dataType: 'json',
        success: function (data){
            if (data.control == 1){
                $(_phone_id).text(data.phone_mask);
                $(_phone_id).attr('href', 'tel:' + data.phone);
                $(_this).html('<i class="fa fa-check-square"></i> Qabul qilindi');
                Command: toastr["success"]("Qabul qilindi")
                toastr.options = {
                  "closeButton": false,
                  "debug": false,
                  "newestOnTop": false,
                  "progressBar": false,
                  "positionClass": "toast-top-right",
                  "preventDuplicates": false,
                  "onclick": null,
                  "showDuration": "300",
                  "hideDuration": "1000",
                  "timeOut": "5000",
                  "extendedTimeOut": "1000",
                  "showEasing": "swing",
                  "hideEasing": "linear",
                  "showMethod": "fadeIn",
                  "hideMethod": "fadeOut"
                }
            }else if(data.control == 1){
                $(_this).html('<i class="fa fa-check-square"></i> Qabul qilingan');
                $(_this).prop('disabled', false);
                Command: toastr["success"]("Qabul qilindi")
                toastr.options = {
                  "closeButton": false,
                  "debug": false,
                  "newestOnTop": false,
                  "progressBar": false,
                  "positionClass": "toast-top-right",
                  "preventDuplicates": false,
                  "onclick": null,
                  "showDuration": "300",
                  "hideDuration": "1000",
                  "timeOut": "5000",
                  "extendedTimeOut": "1000",
                  "showEasing": "swing",
                  "hideEasing": "linear",
                  "showMethod": "fadeIn",
                  "hideMethod": "fadeOut"
                }
            }else{
                $(_this).html('<i class="fa fa-check"></i> Qabul qilish');
                Command: toastr["error"]("Allaqachon qabul qilingan")
                toastr.options = {
                  "closeButton": false,
                  "debug": false,
                  "newestOnTop": false,
                  "progressBar": false,
                  "positionClass": "toast-top-right",
                  "preventDuplicates": false,
                  "onclick": null,
                  "showDuration": "300",
                  "hideDuration": "1000",
                  "timeOut": "5000",
                  "extendedTimeOut": "1000",
                  "showEasing": "swing",
                  "hideEasing": "linear",
                  "showMethod": "fadeIn",
                  "hideMethod": "fadeOut"
                }
            }
        },
         error: function () {
            $(_this).html('<i class="fa fa-times"></i> Xato yuz berdi');
        }
    });
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
            <h3 class="page-title"><?=Yii::t("app", "New orders")?></h3>
            <!-- END PAGE TITLE-->
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <?= AlertWidget::widget()?>
                    <div class="portlet-body">
                        <div class="row">
                            <?php foreach ($model as $item):?>
                                <?= OrderReturnWidget::widget([
                                    'model' => $item
                                ])?>
                            <?php endforeach;?>
                        </div>
                        <div class="row">
                            <div class="col-md-5 col-sm-5">
                                <div class="dataTables_info" id="sample_1_info" role="status" aria-live="polite">
                                    <?= CountWidget::widget([
                                        'model' => $model,
                                        'count' => $counts,
                                        'pagination' => $pagination
                                    ])?>
                                </div>
                            </div>
                            <div class="col-md-7 col-sm-7">
                                <div class="dataTables_paginate paging_bootstrap_full_number" id="sample_1_paginate">
                                    <?=  LinkPager::widget([
                                        'pagination' => $pagination,
                                        'options' => [
                                            'class' => 'pagination bootpag'
                                        ]
                                    ]); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END CONTENT BODY -->
    </div>
    <!-- END CONTENT -->
<?php
Modal::begin([
    'header' => "<h4>" . Yii::t("app", "Change status") . "</h4>",
    'id' => "myModal",
    "size" => "modal-lg",
]);

echo "<div id='modalContent'>
    
    </div>";

Modal::end();
?>