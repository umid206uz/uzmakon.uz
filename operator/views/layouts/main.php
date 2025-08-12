<?php

/* @var $this \yii\web\View */
/* @var $content string */

use common\models\Setting;
use operator\models\User;
use yii\helpers\Html;
use operator\assets\AppAsset;
use operator\assets\ProfileAsset;
use yii\helpers\Url;

$setting = Setting::findOne(1);
$user = User::findOne(Yii::$app->user->id);
$user_role = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
$user_role = reset($user_role);
if (Yii::$app->controller->action->id == 'account'){
    ProfileAsset::register($this);
}else{
    AppAsset::register($this);
}
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link rel="icon" href="https://<?=Yii::$app->params['og_site_name']['content']?>/backend/web/uploads/<?=$setting->favicon?>" type="image/x-icon">
</head>
<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">
<?php $this->beginBody() ?>
<!-- BEGIN HEADER -->
<div class="page-header navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner ">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
            <a href="<?= ($user_role->name == 'operator') ? Url::to(['operator/index']) : Url::to(['returned/index'])?>">
                <img style="margin-top: 7px" src="https://<?=Yii::$app->params['og_site_name']['content']?>/backend/web/uploads/<?=$setting->logo_bottom?>" alt="logo" class="logo-default" /></a>
            <div class="menu-toggler sidebar-toggler">
                <span></span>
            </div>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
            <span></span>
        </a>
        <!-- END RESPONSIVE MENU TOGGLER -->
        <!-- BEGIN TOP NAVIGATION MENU -->
        <div class="top-menu">
            <ul class="nav navbar-nav pull-right">
                <li class="nav-item" style="display: flex; align-items: center; padding-right: 10px; margin-top: 5px;">
                    <a href="<?= Url::to(['/site/create-order'])?>" class="btn btn-primary" title="Yangi buyurtma qo'shish" style="padding: 8px 12px; border-radius: 4px;">
                        <i class="fa fa-plus" style="font-size: 16px;"></i>
                    </a>
                </li>
                <!-- BEGIN USER LOGIN DROPDOWN -->
                <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                <li class="dropdown dropdown-user">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                        <img alt="" class="img-circle" src="<?=$user->avatar?>"/>
                        <span class="username username-hide-on-mobile"> <?=$user->username?> </span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-default">
                        <li>
                            <a href="<?= Url::to(['/site/account'])?>">
                                <i class="icon-user"></i>
                                <?=Yii::t("app", "My Profile")?>
                            </a>
                        </li>
                        <li>
                            <a href="<?= Url::to(['/site/payment'])?>">
                                <i class="fa fa-money"></i>
                                <?=Yii::t("app", "Payment")?>
                            </a>
                        </li>
                        <li class="divider"> </li>
                        <li>
                            <a data-method="post" href="<?= Url::to(['/site/logout'])?>">
                                <i class="icon-key"></i>
                                <?=Yii::t("app", "Logout")?>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- END USER LOGIN DROPDOWN -->
            </ul>
        </div>
        <!-- END TOP NAVIGATION MENU -->
    </div>
    <!-- END HEADER INNER -->
</div>
<!-- END HEADER -->
<!-- BEGIN HEADER & CONTENT DIVIDER -->
<div class="clearfix"> </div>
<!-- END HEADER & CONTENT DIVIDER -->
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN SIDEBAR -->
    <div class="page-sidebar-wrapper">
        <!-- BEGIN SIDEBAR -->
        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
        <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
        <div class="page-sidebar navbar-collapse collapse">
            <!-- BEGIN SIDEBAR MENU -->
            <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
            <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
            <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
            <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
            <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
            <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
            <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
                <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
                <li class="sidebar-toggler-wrapper hide">
                    <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                    <div class="sidebar-toggler">
                        <span></span>
                    </div>
                    <!-- END SIDEBAR TOGGLER BUTTON -->
                </li>
                <!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
                <li class="sidebar-search-wrapper">
                    <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
                    <!-- DOC: Apply "sidebar-search-bordered" class the below search form to have bordered search box -->
                    <!-- DOC: Apply "sidebar-search-bordered sidebar-search-solid" class the below search form to have bordered & solid search box -->
                    <form class="sidebar-search" action="<?= ($user_role->name == 'operator') ? Url::to(['operator/search']) : Url::to(['returned/search'])?>" method="GET">
                        <a href="javascript:;" class="remove">
                            <i class="icon-close"></i>
                        </a>
                        <div class="input-group">
                            <input type="text" name="key" class="form-control" placeholder="<?=Yii::t("app", "Search")?>...">
                            <span class="input-group-btn">
                                <a href="javascript:;" class="btn submit">
                                    <i class="icon-magnifier"></i>
                                </a>
                            </span>
                        </div>
                    </form>
                    <!-- END RESPONSIVE QUICK SEARCH FORM -->
                </li>
                <?php if ($user_role->name == 'operator'):?>
                <li class="nav-item <?=(Yii::$app->controller->action->id == "index") ? "start active open" : ""?> ">
                    <a href="<?= Url::to(['operator/index'])?>" class="nav-link nav-toggle">
                        <i class="icon-layers"></i>
                        <span class="title"><?=Yii::t("app","New orders")?></span>
                        <span class="selected"></span>
                    </a>
                </li>
                <li class="nav-item <?=(Yii::$app->controller->action->id == "apply") ? "start active open" : ""?> ">
                    <a href="<?= Url::to(['operator/apply'])?>" class="nav-link nav-toggle">
                        <i class="icon-layers"></i>
                        <span class="title"><?=Yii::t("app","Accepted")?></span>
                        <span class="selected"></span>
                    </a>
                </li>
                <li class="nav-item <?=(Yii::$app->controller->action->id == "order-complete") ? "start active open" : ""?>">
                    <a href="<?= Url::to(['operator/order-complete'])?>" class="nav-link nav-toggle">
                        <i class="fa fa-chevron-down"></i>
                        <span class="title"><?=Yii::t("app","Read to delivery")?></span>
                        <span class="selected"></span>
                    </a>
                </li>
                <li class="nav-item <?=(Yii::$app->controller->action->id == "ordering") ? "start active open" : ""?>">
                    <a href="<?= Url::to(['operator/ordering'])?>" class="nav-link nav-toggle">
                        <i class="fa fa-car"></i>
                        <span class="title"><?=Yii::t("app","Being delivered")?></span>
                        <span class="selected"></span>
                    </a>
                </li>
                <li class="nav-item <?=(Yii::$app->controller->action->id == "ordered") ? "start active open" : ""?>">
                    <a href="<?= Url::to(['operator/ordered'])?>" class="nav-link nav-toggle">
                        <i class="fa fa-arrows"></i>
                        <span class="title"><?=Yii::t("app","Delivered")?></span>
                        <span class="selected"></span>
                    </a>
                </li>
                <li class="nav-item <?=(Yii::$app->controller->action->id == "waiting") ? "start active open" : ""?>">
                    <a href="<?= Url::to(['operator/waiting'])?>" class="nav-link nav-toggle">
                        <i class="fa fa-hourglass-2"></i>
                        <span class="title"><?=Yii::t("app","Then takes")?></span>
                        <span class="selected"></span>
                    </a>
                </li>
                <li class="nav-item <?=(Yii::$app->controller->action->id == "hold") ? "start active open" : ""?>">
                    <a href="<?= Url::to(['operator/hold'])?>" class="nav-link nav-toggle">
                        <i class="fa fa-thumbs-down"></i>
                        <span class="title"><?=Yii::t("app","Hold")?></span>
                        <span class="selected"></span>
                    </a>
                </li>
                <li class="nav-item <?=(Yii::$app->controller->action->id == "feedback") ? "start active open" : ""?>">
                    <a href="<?= Url::to(['operator/feedback'])?>" class="nav-link nav-toggle">
                        <i class="fa fa-headphones"></i>
                        <span class="title"><?=Yii::t("app","Feedback")?></span>
                        <span class="selected"></span>
                    </a>
                </li>
                <li class="nav-item <?=(Yii::$app->controller->action->id == "come-back") ? "start active open" : ""?>">
                    <a href="<?= Url::to(['operator/come-back'])?>" class="nav-link nav-toggle">
                        <i class="fa fa-user-times"></i>
                        <span class="title"><?=Yii::t("app", "Archive")?></span>
                        <span class="selected"></span>
                    </a>
                </li>
                <li class="nav-item <?=(Yii::$app->controller->action->id == "returned") ? "start active open" : ""?>">
                    <a href="<?= Url::to(['operator/returned'])?>" class="nav-link nav-toggle">
                        <i class="fa fa-reply"></i>
                        <span class="title"><?=Yii::t("app", "Came back")?></span>
                        <span class="selected"></span>
                    </a>
                </li>
                <li class="nav-item <?=(Yii::$app->controller->action->id == "black-list") ? "start active open" : ""?>">
                    <a href="<?= Url::to(['operator/black-list'])?>" class="nav-link nav-toggle">
                        <i class="fa fa-remove"></i>
                        <span class="title"><?=Yii::t("app","Black list")?></span>
                        <span class="selected"></span>
                    </a>
                </li>
                <?php elseif ($user_role->name == 'operator_returned'):?>
                    <li class="nav-item <?=(Yii::$app->controller->action->id == "index") ? "start active open" : ""?> ">
                        <a href="<?= Url::to(['returned/index'])?>" class="nav-link nav-toggle">
                            <i class="icon-layers"></i>
                            <span class="title"><?=Yii::t("app","New orders")?></span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <li class="nav-item <?=(Yii::$app->controller->action->id == "apply") ? "start active open" : ""?> ">
                        <a href="<?= Url::to(['returned/apply'])?>" class="nav-link nav-toggle">
                            <i class="icon-layers"></i>
                            <span class="title"><?=Yii::t("app","Accepted")?></span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <li class="nav-item <?=(Yii::$app->controller->action->id == "order-complete") ? "start active open" : ""?>">
                        <a href="<?= Url::to(['returned/order-complete'])?>" class="nav-link nav-toggle">
                            <i class="fa fa-chevron-down"></i>
                            <span class="title"><?=Yii::t("app","Read to delivery")?></span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <li class="nav-item <?=(Yii::$app->controller->action->id == "ordering") ? "start active open" : ""?>">
                        <a href="<?= Url::to(['returned/ordering'])?>" class="nav-link nav-toggle">
                            <i class="fa fa-car"></i>
                            <span class="title"><?=Yii::t("app","Being delivered")?></span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <li class="nav-item <?=(Yii::$app->controller->action->id == "ordered") ? "start active open" : ""?>">
                        <a href="<?= Url::to(['returned/ordered'])?>" class="nav-link nav-toggle">
                            <i class="fa fa-arrows"></i>
                            <span class="title"><?=Yii::t("app","Delivered")?></span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <li class="nav-item <?=(Yii::$app->controller->action->id == "waiting") ? "start active open" : ""?>">
                        <a href="<?= Url::to(['returned/waiting'])?>" class="nav-link nav-toggle">
                            <i class="fa fa-hourglass-2"></i>
                            <span class="title"><?=Yii::t("app","Then takes")?></span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <li class="nav-item <?=(Yii::$app->controller->action->id == "hold") ? "start active open" : ""?>">
                        <a href="<?= Url::to(['returned/hold'])?>" class="nav-link nav-toggle">
                            <i class="fa fa-thumbs-down"></i>
                            <span class="title"><?=Yii::t("app","Hold")?></span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <li class="nav-item <?=(Yii::$app->controller->action->id == "come-back") ? "start active open" : ""?>">
                        <a href="<?= Url::to(['returned/come-back'])?>" class="nav-link nav-toggle">
                            <i class="fa fa-user-times"></i>
                            <span class="title"><?=Yii::t("app", "Archive")?></span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <li class="nav-item <?=(Yii::$app->controller->action->id == "returned") ? "start active open" : ""?>">
                        <a href="<?= Url::to(['returned/returned'])?>" class="nav-link nav-toggle">
                            <i class="fa fa-reply"></i>
                            <span class="title"><?=Yii::t("app", "Came back")?></span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <li class="nav-item <?=(Yii::$app->controller->action->id == "black-list") ? "start active open" : ""?>">
                        <a href="<?= Url::to(['returned/black-list'])?>" class="nav-link nav-toggle">
                            <i class="fa fa-remove"></i>
                            <span class="title"><?=Yii::t("app","Black list")?></span>
                            <span class="selected"></span>
                        </a>
                    </li>
                <?php endif;?>
                <li class="nav-item <?=(Yii::$app->controller->action->id == "account") ? "start active open" : ""?>">
                    <a href="<?= Url::to(['site/account'])?>" class="nav-link nav-toggle">
                        <i class="icon-user"></i>
                        <span class="title"><?=Yii::t("app", "My Profile")?></span>
                        <span class="selected"></span>
                    </a>
                </li>
                <li class="nav-item <?=(Yii::$app->controller->action->id == "payment") ? "start active open" : ""?>">
                    <a href="<?= Url::to(['site/payment'])?>" class="nav-link nav-toggle">
                        <i class="fa fa-money"></i>
                        <span class="title"><?=Yii::t("app", "Payment")?></span>
                        <span class="selected"></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a data-method="POST" href="<?= Url::to(['site/logout'])?>" class="nav-link nav-toggle">
                        <i class="icon-key"></i>
                        <span class="title"><?=Yii::t("app", "Logout")?></span>
                        <span class="selected"></span>
                    </a>
                </li>
            </ul>
            <!-- END SIDEBAR MENU -->
            <!-- END SIDEBAR MENU -->
        </div>
        <!-- END SIDEBAR -->
    </div>
    <!-- END SIDEBAR -->
    <?= $content?>
</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<div class="page-footer">
    <div class="page-footer-inner"> <?=date('Y')?> &copy; <?=Yii::$app->params['og_site_name']['content']?>
        <a href="http://t.me/umid206" title="<?=Yii::$app->params['og_site_name']['content']?>" target="_blank">Created By umid206!</a>
    </div>
    <div class="scroll-to-top">
        <i class="icon-arrow-up"></i>
    </div>
</div>
<!-- END FOOTER -->
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>