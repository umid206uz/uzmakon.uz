<?php

/* @var $this \yii\web\View */
/* @var $content string */
/* @var $user common\models\User */
/* @var $setting common\models\Setting */

use common\models\Setting;
use common\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\AppAsset;

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
        // $this->registerMetaTag(Yii::$app->params['og_image'], 'og_image');
        $this->registerMetaTag(Yii::$app->params['og_width'], 'og_width');
        $this->registerMetaTag(Yii::$app->params['og_height'], 'og_height');
        ?>
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <link rel="canonical" href="<?=Yii::$app->request->hostInfo?>">
        <?php $this->head() ?>
        <link rel="icon" href="/backend/web/uploads/<?=$setting->favicon?>" type="image/x-icon">
    </head>
    <body>
    <?php $this->beginBody() ?>

    <!-- Start header area -->
    <header class="header__section">
        <div class="header__topbar bg__secondary">
            <div class="container-fluid">
                <div class="header__topbar--inner d-flex align-items-center justify-content-between">
                    <div class="header__shipping">
                        <ul class="header__shipping--wrapper d-flex">
                            <li class="header__shipping--text text-white"><?=Yii::t("app", "Welcome to UcharSavdo.uz online Store")?></li>
                            <li class="header__shipping--text text-white d-sm-2-none">
                                <img class="header__shipping--text__icon" src="/frontend/web/template/img/icon/bus.png" alt="bus-icon"> <?=Yii::t("app", "Free shipping")?>
                            </li>
                            <li class="header__shipping--text text-white d-sm-2-none">
                                <img class="header__shipping--text__icon" src="/frontend/web/template/img/icon/email.png" alt="email-icon">
                                <a class="header__shipping--text__link" href="mailto:<?=$setting->mail?>"><?=$setting->mail?></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="main__header header__sticky">
            <div class="container-fluid">
                <div class="main__header--inner position__relative d-flex justify-content-between align-items-center">
                    <div class="main__logo">
                        <a class="main__logo--link" href="<?=($action == 'link') ? "#" : "/"?>">
                            <img style="width: 220px" class="main__logo--img" src="/backend/web/uploads/<?=$setting->logo?>" alt="logo-img">
                        </a>
                    </div>
                    <div class="header__search--widget header__sticky--none d-none d-lg-block">
                        <form class="d-flex header__search--form" action="<?= Url::to(['/site/search'])?>">
                            <div class="header__search--box">
                                <label>
                                    <input name="key" class="header__search--input" placeholder="<?=Yii::t("app", "Search")?>..." type="text">
                                </label>
                                <button class="header__search--button bg__secondary text-white" type="submit" aria-label="search button">
                                    <svg class="header__search--button__svg" xmlns="http://www.w3.org/2000/svg" width="27.51" height="26.443" viewBox="0 0 512 512"><path d="M221.09 64a157.09 157.09 0 10157.09 157.09A157.1 157.1 0 00221.09 64z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M338.29 338.29L448 448"></path></svg>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="header__account header__sticky--none">
                        <ul class="d-flex">
                            <?php if ($action != 'link'):?>
                                <?php if (Yii::$app->user->isGuest):?>
                                <li class="header__account--items">
                                    <a class="header__account--btn" href="https://admin.uzmakon.uz">
                                        <svg xmlns="http://www.w3.org/2000/svg"  width="26.51" height="23.443" viewBox="0 0 512 512">
                                            <path d="M344 144c-3.92 52.87-44 96-88 96s-84.15-43.12-88-96c-4-55 35-96 88-96s92 42 88 96z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/>
                                            <path d="M256 304c-87 0-175.3 48-191.64 138.6C62.39 453.52 68.57 464 80 464h352c11.44 0 17.62-10.48 15.65-21.4C431.3 352 343 304 256 304z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"/>
                                        </svg>
                                        <span class="header__account--btn__text"><?=Yii::t("app", "My Account")?></span>
                                    </a>
                                </li>
                                <?php else:?>
                                <li class="header__account--items">
                                    <a class="header__account--btn" href="https://admin.uzmakon.uz">
                                        <svg xmlns="http://www.w3.org/2000/svg"  width="26.51" height="23.443" viewBox="0 0 512 512">
                                            <path d="M344 144c-3.92 52.87-44 96-88 96s-84.15-43.12-88-96c-4-55 35-96 88-96s92 42 88 96z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/>
                                            <path d="M256 304c-87 0-175.3 48-191.64 138.6C62.39 453.52 68.57 464 80 464h352c11.44 0 17.62-10.48 15.65-21.4C431.3 352 343 304 256 304z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"/>
                                        </svg>
                                        <span class="header__account--btn__text"><?=Yii::t("app", "My Account")?></span>
                                    </a>
                                </li>
                                <?php endif;?>
                            <?php endif;?>
                        </ul>
                    </div>
                    <div class="header__account header__account2 header__sticky--block">
                        <ul class="d-flex">
                            <li class="header__account--items header__account2--items  header__account--search__items d-none d-lg-block">
                                <a class="header__account--btn search__open--btn" href="javascript:void(0)" data-offcanvas>
                                    <svg class="header__search--button__svg" xmlns="http://www.w3.org/2000/svg" width="26.51" height="23.443" viewBox="0 0 512 512"><path d="M221.09 64a157.09 157.09 0 10157.09 157.09A157.1 157.1 0 00221.09 64z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M338.29 338.29L448 448"/></svg>
                                    <span class="visually-hidden">Search</span>
                                </a>
                            </li>
                            <li class="header__account--items header__account2--items">
                                <a class="header__account--btn" href="https://admin.uzmakon.uz">
                                    <svg xmlns="http://www.w3.org/2000/svg"  width="26.51" height="23.443" viewBox="0 0 512 512"><path d="M344 144c-3.92 52.87-44 96-88 96s-84.15-43.12-88-96c-4-55 35-96 88-96s92 42 88 96z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/><path d="M256 304c-87 0-175.3 48-191.64 138.6C62.39 453.52 68.57 464 80 464h352c11.44 0 17.62-10.48 15.65-21.4C431.3 352 343 304 256 304z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"/></svg>
                                    <span class="visually-hidden"><?=Yii::t("app", "My Account")?></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="offcanvas__stikcy--toolbar">
            <ul class="d-flex justify-content-between">
                <li class="offcanvas__stikcy--toolbar__list">
                    <a class="offcanvas__stikcy--toolbar__btn" href="/">
                    <span class="offcanvas__stikcy--toolbar__icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" width="21.51" height="21.443" viewBox="0 0 22 17"><path fill="currentColor" d="M20.9141 7.93359c.1406.11719.2109.26953.2109.45703 0 .14063-.0469.25782-.1406.35157l-.3516.42187c-.1172.14063-.2578.21094-.4219.21094-.1406 0-.2578-.04688-.3515-.14062l-.9844-.77344V15c0 .3047-.1172.5625-.3516.7734-.2109.2344-.4687.3516-.7734.3516h-4.5c-.3047 0-.5742-.1172-.8086-.3516-.2109-.2109-.3164-.4687-.3164-.7734v-3.6562h-2.25V15c0 .3047-.11719.5625-.35156.7734-.21094.2344-.46875.3516-.77344.3516h-4.5c-.30469 0-.57422-.1172-.80859-.3516-.21094-.2109-.31641-.4687-.31641-.7734V8.46094l-.94922.77344c-.11719.09374-.24609.14062-.38672.14062-.16406 0-.30468-.07031-.42187-.21094l-.35157-.42187C.921875 8.625.875 8.50781.875 8.39062c0-.1875.070312-.33984.21094-.45703L9.73438.832031C10.1094.527344 10.5312.375 11 .375s.8906.152344 1.2656.457031l8.6485 7.101559zm-3.7266 6.50391V7.05469L11 1.99219l-6.1875 5.0625v7.38281h3.375v-3.6563c0-.3046.10547-.5624.31641-.7734.23437-.23436.5039-.35155.80859-.35155h3.375c.3047 0 .5625.11719.7734.35155.2344.211.3516.4688.3516.7734v3.6563h3.375z"></path></svg>
                        </span>
                        <span class="offcanvas__stikcy--toolbar__label"><?=Yii::t("app", "Home")?></span>
                    </a>
                </li>
                <li class="offcanvas__stikcy--toolbar__list">
                    <a class="offcanvas__stikcy--toolbar__btn" target="_blank" href="<?=$setting->telegram?>">
                    <span class="offcanvas__stikcy--toolbar__icon">
                        <svg version="1.1" id="Layer_1" width="16.497" height="16.492" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                             viewBox="0 0 511.999 511.999" style="enable-background:new 0 0 511.999 511.999;" xml:space="preserve">
                        <path style="fill:#C3C3C7;" d="M165.323,267.452L395.89,125.446c4.144-2.545,8.407,3.058,4.849,6.359L210.454,308.684
                            c-6.688,6.226-11.003,14.558-12.225,23.602l-6.482,48.036c-0.858,6.414-9.868,7.05-11.638,0.843l-24.929-87.595
                            C152.325,283.578,156.486,272.907,165.323,267.452z"/>
                        <path style="fill:#DEDEE0;" d="M9.043,246.86l117.975,44.032l45.664,146.854c2.922,9.405,14.423,12.882,22.057,6.641l65.761-53.61
                            c6.893-5.617,16.712-5.897,23.916-0.667l118.61,86.113c8.166,5.936,19.736,1.461,21.784-8.407l86.888-417.947
                            c2.236-10.779-8.356-19.772-18.62-15.802L8.905,220.845C-3.043,225.453-2.939,242.369,9.043,246.86z M165.323,267.452
                            L395.89,125.446c4.144-2.545,8.407,3.058,4.849,6.359L210.454,308.684c-6.688,6.226-11.003,14.558-12.225,23.602l-6.482,48.036
                            c-0.858,6.414-9.868,7.05-11.638,0.843l-24.929-87.595C152.325,283.578,156.486,272.907,165.323,267.452z"/>
                        </svg>
                        </span>
                        <span class="offcanvas__stikcy--toolbar__label"><?=Yii::t("app", "Telegram")?></span>
                    </a>
                </li>
                <li class="offcanvas__stikcy--toolbar__list">
                    <a class="offcanvas__stikcy--toolbar__btn" target="_blank" href="<?=$setting->instagram?>">
                    <span class="offcanvas__stikcy--toolbar__icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16.497" height="16.492" viewBox="0 0 19.497 19.492">
                            <path data-name="Icon awesome-instagram" d="M9.747,6.24a5,5,0,1,0,5,5A4.99,4.99,0,0,0,9.747,6.24Zm0,8.247A3.249,3.249,0,1,1,13,11.238a3.255,3.255,0,0,1-3.249,3.249Zm6.368-8.451A1.166,1.166,0,1,1,14.949,4.87,1.163,1.163,0,0,1,16.115,6.036Zm3.31,1.183A5.769,5.769,0,0,0,17.85,3.135,5.807,5.807,0,0,0,13.766,1.56c-1.609-.091-6.433-.091-8.042,0A5.8,5.8,0,0,0,1.64,3.13,5.788,5.788,0,0,0,.065,7.215c-.091,1.609-.091,6.433,0,8.042A5.769,5.769,0,0,0,1.64,19.341a5.814,5.814,0,0,0,4.084,1.575c1.609.091,6.433.091,8.042,0a5.769,5.769,0,0,0,4.084-1.575,5.807,5.807,0,0,0,1.575-4.084c.091-1.609.091-6.429,0-8.038Zm-2.079,9.765a3.289,3.289,0,0,1-1.853,1.853c-1.283.509-4.328.391-5.746.391S5.28,19.341,4,18.837a3.289,3.289,0,0,1-1.853-1.853c-.509-1.283-.391-4.328-.391-5.746s-.113-4.467.391-5.746A3.289,3.289,0,0,1,4,3.639c1.283-.509,4.328-.391,5.746-.391s4.467-.113,5.746.391a3.289,3.289,0,0,1,1.853,1.853c.509,1.283.391,4.328.391,5.746S17.855,15.705,17.346,16.984Z" transform="translate(0.004 -1.492)" fill="currentColor"></path>
                        </svg>
                    </span>
                        <span class="offcanvas__stikcy--toolbar__label"><?=Yii::t("app", "Instagram")?></span>
                    </a>
                </li>
                <?php if (!Yii::$app->user->isGuest && $action != 'link'):?>
                    <li class="offcanvas__stikcy--toolbar__list">
                        <a data-method="POST" class="offcanvas__stikcy--toolbar__btn" href="<?= Url::to(['/site/main'])?>">
                    <span class="offcanvas__stikcy--toolbar__icon">
                        <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" width="18.51" height="17.443" viewBox="0 0 448 512"><path d="M416 32H32A32 32 0 0 0 0 64v384a32 32 0 0 0 32 32h384a32 32 0 0 0 32-32V64a32 32 0 0 0-32-32zm-16 48v152H248V80zm-200 0v152H48V80zM48 432V280h152v152zm200 0V280h152v152z"></path></svg>
                        </span>
                            <span class="offcanvas__stikcy--toolbar__label">Dashboard</span>
                        </a>
                    </li>
                    <li class="offcanvas__stikcy--toolbar__list ">
                        <a class="offcanvas__stikcy--toolbar__btn search__open--btn" href="<?= Url::to(['/site/logout'])?>" data-offcanvas="">
                    <span class="offcanvas__stikcy--toolbar__icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22.51" height="20.443" viewBox="0 0 512 512">
                            <path d="M221.09 64a157.09 157.09 0 10157.09 157.09A157.1 157.1 0 00221.09 64z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></path><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M338.29 338.29L448 448"></path>
                        </svg>
                    </span>
                            <span class="offcanvas__stikcy--toolbar__label"><?=Yii::t("app", "Logout")?></span>
                        </a>
                    </li>
                <?php endif;?>
                <?php if (Yii::$app->user->isGuest && $action != 'link'):?>
                    <li class="offcanvas__stikcy--toolbar__list">
                        <a class="offcanvas__stikcy--toolbar__btn" href="https://admin.uzmakon.uz">
                        <span class="offcanvas__stikcy--toolbar__icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26.51" height="23.443" viewBox="0 0 512 512">
                            <path d="M344 144c-3.92 52.87-44 96-88 96s-84.15-43.12-88-96c-4-55 35-96 88-96s92 42 88 96z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"></path><path d="M256 304c-87 0-175.3 48-191.64 138.6C62.39 453.52 68.57 464 80 464h352c11.44 0 17.62-10.48 15.65-21.4C431.3 352 343 304 256 304z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></path>
                        </svg>
                        </span>
                            <span class="offcanvas__stikcy--toolbar__label"><?=Yii::t("app", "Login")?></span>
                        </a>
                    </li>
                <?php endif;?>
            </ul>
        </div>

        <!-- Start serch box area -->
        <div class="predictive__search--box ">
            <div class="predictive__search--box__inner">
                <h2 class="predictive__search--title"><?=Yii::t("app", "Search")?></h2>
                <form class="predictive__search--form" action="<?= Url::to(['/site/search'])?>">
                    <label>
                        <input name="key" class="predictive__search--input" placeholder="<?=Yii::t("app", "Search")?>" type="text">
                    </label>
                    <button class="predictive__search--button" aria-label="search button" type="submit"><svg class="header__search--button__svg" xmlns="http://www.w3.org/2000/svg" width="30.51" height="25.443" viewBox="0 0 512 512"><path d="M221.09 64a157.09 157.09 0 10157.09 157.09A157.1 157.1 0 00221.09 64z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M338.29 338.29L448 448"/></svg>  </button>
                </form>
            </div>
            <button class="predictive__search--close__btn" aria-label="search close button" data-offcanvas>
                <svg class="predictive__search--close__icon" xmlns="http://www.w3.org/2000/svg" width="40.51" height="30.443"  viewBox="0 0 512 512"><path fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M368 368L144 144M368 144L144 368"/></svg>
            </button>
        </div>
        <!-- End serch box area -->

    </header>
    <!-- End header area -->


    <?=$content?>

    <!-- Start footer section -->
    <footer class="footer__section bg__black">
        <div class="container-fluid">
            <div class="footer__bottom d-flex justify-content-between align-items-center">
                <p class="copyright__content text-ofwhite m-0"><?=$setting->copyrightTranslate?></p>
            </div>
        </div>
    </footer>
    <!-- End footer section -->

    <!-- Scroll top bar -->
    <button id="scroll__top"><svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="48" d="M112 244l144-144 144 144M256 120v292"/></svg></button>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>