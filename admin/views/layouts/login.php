<?php

/* @var $this \yii\web\View */
/* @var $content string */

use common\models\Setting;
use admin\assets\LoginAsset;
use yii\helpers\Html;

$setting = Setting::findOne(1);
LoginAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>" itemscope="itemscope" itemtype="http://schema.org/WebPage" data-color="dark-blue">
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
        <link rel="icon" href="https://<?=Yii::$app->params['og_url_name']['content']?>/backend/web/uploads/<?=$setting->favicon?>" type="image/x-icon">
    </head>
    <body class="vh-100">
    <?php $this->beginBody() ?>

    <?=$content?>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>