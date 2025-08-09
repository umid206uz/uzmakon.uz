<?php

/* @var $this \yii\web\View */
/* @var $content string */

use common\models\Setting;
use yii\helpers\Html;
use frontend\assets\AppAsset;

$setting = Setting::findOne(1);
AppAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" itemscope="itemscope" itemtype="http://schema.org/WebPage">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="text/html; charset=UTF-8">
    <meta name="google-site-verification" content="zgbQGZW2HoD_PtpH2fiFHV-UCHbCLMkPOL-ajtngS9E" />
    <meta name="yandex-verification" content="240c959fa9455a1d">
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
    <link rel="icon" href="/backend/web/uploads/<?=$setting->favicon?>" type="image/x-icon">
</head>
<body>
<?php $this->beginBody() ?>
<!-- Preloader-->
<div class="preloader" id="preloader">
    <div class="spinner-grow text-secondary" role="status">
        <div class="sr-only">Loading...</div>
    </div>
</div>
<!-- Order/Payment Success-->
<div class="order-success-wrapper">
    <div class="content">
        <svg class="bi bi-cart-check text-white mb-3" xmlns="http://www.w3.org/2000/svg" width="42" height="42" fill="currentColor" viewBox="0 0 16 16">
            <path d="M11.354 6.354a.5.5 0 0 0-.708-.708L8 8.293 6.854 7.146a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0l3-3z"></path>
            <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
        </svg>
        <h5><?= Yii::$app->session->getFlash('success') ?></h5>
        <p><?=Yii::t("app", "Expect, in the near future our managers will contact you using the specified contact information!")?></p>
        <a class="btn btn-warning btn-sm mt-3" href="/"><?=Yii::t("app", "Back to home")?></a>
    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>