<?php

/* @var $this \yii\web\View */

/* @var $content string */

use yii\helpers\Html;
use operator\assets\LoginAsset;
use common\models\Setting;

$setting = Setting::findOne(1);
LoginAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link rel="icon" href="https://<?=Yii::$app->params['og_site_name']['content']?>/backend/web/uploads/<?=$setting->favicon?>" type="image/x-icon">
</head>
<body class="login">
<?php $this->beginBody() ?>
    <!-- BEGIN LOGO -->
    <div class="logo">
        <a href="/">
            <img style="max-width: 200px;" src="https://<?=Yii::$app->params['og_site_name']['content']?>/backend/web/uploads/<?=$setting->logo?>" alt="">
        </a>
    </div>
    <!-- END LOGO -->
    <?= $content ?>
    <!-- BEGIN COPYRIGHT -->
    <div class="copyright"> <?=date("Y")?> &copy; - Operator panel. </div>
    <!-- END COPYRIGHT -->
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
