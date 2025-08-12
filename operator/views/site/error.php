<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use operator\assets\AppAsset;
use yii\helpers\Html;
use yii\web\View;

$this->title = $name;
$this->registerCssFile(Yii::$app->request->BaseUrl . 'pages/css/error.min.css', ['position' => View::POS_END, 'depends' => [AppAsset::className()]]);
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
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span><?= Html::encode($this->title) ?></span>
                </li>
            </ul>
        </div>
        <!-- END PAGE BAR -->
        <!-- BEGIN PAGE TITLE-->
        <h3 class="page-title"> <?= Html::encode($this->title) ?>
        </h3>
        <!-- END PAGE TITLE-->
        <!-- END PAGE HEADER-->
        <div class="row">
            <div class="col-md-12 page-404">
                <div class="number font-green"> 404 </div>
                <div class="details">
                    <h3>Afsus! Siz adashdingiz.</h3>
                    <p> <?= nl2br(Html::encode($message)) ?>
                        <br/>
                        <a href="/"> Asosiy sahifaga qaytish </a> </p>
                    <form action="#">
                        <div class="input-group input-medium">
                            <input type="text" class="form-control" placeholder="keyword...">
                            <span class="input-group-btn">
                                <button type="submit" class="btn green">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                        <!-- /input-group -->
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->
