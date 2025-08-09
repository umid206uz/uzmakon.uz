<?php

/* @var $this \yii\web\View */
/* @var $content string */
/* @var $user common\models\User */
/* @var $setting common\models\Setting */

use admin\assets\AppAsset;
use common\models\Setting;
use admin\models\User;
use yii\helpers\Html;
use yii\helpers\Url;

$setting = Setting::findOne(1);
$user = User::findByUsername(Yii::$app->user->identity->username);
$action = Yii::$app->controller->action->id;
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>" itemscope="itemscope" itemtype="http://schema.org/WebPage">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
        <meta http-equiv="X-UA-Compatible" content="text/html; charset=UTF-8">
        <meta name="robots" content="index, follow">
        <?php
        $this->registerMetaTag(Yii::$app->params['og_site_name'], 'og_site_name');
        $this->registerMetaTag(Yii::$app->params['og_type'], 'og_type');
        $this->registerMetaTag(Yii::$app->params['og_title'], 'og_title');
        $this->registerMetaTag(Yii::$app->params['og_description'], 'og_description');
        $this->registerMetaTag(Yii::$app->params['og_url'], 'og_url');
        $this->registerMetaTag(Yii::$app->params['og_image'], 'og_image');
        $this->registerMetaTag(Yii::$app->params['og_width'], 'og_width');
        $this->registerMetaTag(Yii::$app->params['og_height'], 'og_height');
        ?>
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <link rel="canonical" href="<?=Yii::$app->request->hostInfo?>">
        <?php $this->head() ?>
        <link rel="icon" href="https://<?=Yii::$app->params['og_url_name']['content']?>/backend/web/uploads/<?=$setting->favicon?>" type="image/x-icon">
    </head>
    <body>
    <?php $this->beginBody() ?>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            <a href="<?= Url::to(['/'])?>" class="brand-logo">
                <img class="logo-abbr" src="https://<?=Yii::$app->params['og_url_name']['content']?>/admin/web/template/images/logo-abbr.png">
                <img class="brand-title" src="https://<?=Yii::$app->params['og_url_name']['content']?>/backend/web/uploads/<?=$setting->logo_bottom?>">
            </a>

            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->

        <!--**********************************
            Header start
        ***********************************-->
        <div class="header">
            <div class="header-content">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                        <div class="header-left">
                            <div class="dashboard_bar">
                                Dashboard
                            </div>
                        </div>

                        <ul class="navbar-nav header-right">
                            <li class="nav-item dropdown notification_dropdown">
                                <form action="<?=Url::to(['/site/offer-search'])?>">
                                    <div class="input-group search-area">
                                        <input name="key" type="text" class="form-control" placeholder="<?=Yii::t("app", "Search")?>...">
                                        <span class="input-group-text"><a href="javascript:void(0)"><i class="flaticon-381-search-2"></i></a></span>
                                    </div>
                                </form>
                            </li>
                            <li class="nav-item dropdown header-profile">
                                <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown">
                                    <img src="<?=$user->avatar?>" width="20" alt=""/>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="<?= Url::to(['/site/account'])?>" class="dropdown-item ai-icon">
                                        <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" class="text-primary" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                        <span class="ms-2"><?=Yii::t("app", "Edit Profile")?> </span>
                                    </a>
                                    <a href="<?= Url::to(['/site/edit'])?>" class="dropdown-item ai-icon">
                                        <svg id="icon-inbox" xmlns="http://www.w3.org/2000/svg" class="text-success" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                        <span class="ms-2"><?=Yii::t("app", "Telegram bot configuration")?> </span>
                                    </a>
                                    <a data-method="POST" href="<?= Url::to(['/site/logout'])?>" class="dropdown-item ai-icon">
                                        <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                                        <span class="ms-2"><?=Yii::t("app", "Logout")?> </span>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
        <div class="deznav">
            <div class="deznav-scroll">
                <ul class="metismenu" id="menu">
                    <li>
                        <a href="<?= Url::to(['/'])?>" aria-expanded="false">
                            <i class="flaticon-381-networking"></i>
                            <span class="nav-text">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= Url::to(['/site/offers'])?>" aria-expanded="false">
                            <i class="flaticon-381-television"></i>
                            <span class="nav-text"><?=Yii::t("app", "Offers")?></span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= Url::to(['/site/streams'])?>" aria-expanded="false">
                            <i class="flaticon-381-controls-3"></i>
                            <span class="nav-text"><?=Yii::t("app", "Streams")?></span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= Url::to(['/site/payment'])?>" aria-expanded="false">
                            <i class="flaticon-381-diamond"></i>
                            <span class="nav-text"><?=Yii::t("app", "Payment")?></span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= Url::to(['/site/order-history'])?>" aria-expanded="false">
                            <i class="flaticon-381-notepad"></i>
                            <span class="nav-text"><?=Yii::t("app", "Order history")?></span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= Url::to(['/site/insert-orders'])?>" aria-expanded="false">
                            <i class="flaticon-381-download"></i>
                            <span class="nav-text"><?=Yii::t("app", "Insert orders")?></span>
                        </a>
                    </li>
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                            <i class="flaticon-381-layer-1"></i>
                            <span class="nav-text"><?=Yii::t("app", "Statistics")?></span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="<?= Url::to(['/site/orders'])?>"><?=Yii::t("app", "All orders")?></a></li>
                            <li><a href="<?= Url::to(['/site/orders-by-stream'])?>"><?=Yii::t("app", "Orders by stream")?></a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="<?= Url::to(['/site/competition'])?>" aria-expanded="false">
                            <i class="flaticon-381-internet"></i>
                            <span class="nav-text"><?=Yii::t("app", "Competition")?></span>
                        </a>
                    </li>
                </ul>
                <div class="copyright">
                    <p><?=Yii::t("app", "Telegram group for admins")?></p>
                    <a href="<?=$setting->admin_group_link?>" target="_blank" class="btn btn-warning btn-rounded">
                        <?=Yii::t("app", "join the group")?>
                        <i class="las la-long-arrow-alt-right ms-sm-4 ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
        <!--**********************************
            Sidebar end
        ***********************************-->

        <!--**********************************
            EventList
        ***********************************-->

        <div class="event-sidebar dz-scroll" id="eventSidebar">
            <div class="card shadow-none rounded-0 bg-transparent h-auto mb-0">
                <div class="card-body text-center event-calender pb-2">
                    <input type='text' class="form-control d-none" id='datetimepicker1' />
                </div>
            </div>
        </div>

        <?=$content?>

        <!--**********************************
            Footer start
        ***********************************-->
        <div class="footer">
            <div class="copyright">
                <?=$setting->copyrightTranslate?>
            </div>
        </div>
        <!--**********************************
            Footer end
        ***********************************-->

        <!--**********************************
           Support ticket button start
        ***********************************-->

        <!--**********************************
           Support ticket button end
        ***********************************-->

    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>