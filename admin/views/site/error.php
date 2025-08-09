<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;
?>
<!--**********************************
    Content body start
***********************************-->
<div class="content-body">
    <div class="container-fluid">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-6">
                <div class="form-input-content text-center error-page">
                    <h1 class="error-text font-weight-bold">404</h1>
                    <h4><i class="fa fa-exclamation-triangle text-warning"></i><?=Yii::t("app","The page you were looking for is not found!")?></h4>
                    <p><?=Yii::t("app","You may have mistyped the address or the page may have moved.")?></p>
                    <div>
                        <a class="btn btn-primary" href="/"><?=Yii::t("app","Return home")?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--**********************************
    Content body end
***********************************-->