<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        "template/css/plugins/swiper-bundle.min.css",
        "template/css/plugins/glightbox.min.css",
        "https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap",
        "template/css/vendor/bootstrap.min.css",
        "template/css/style.css"
    ];
    public $js = [
          ["template/js/vendor/popper.js", "defer" => "defer"],
          ["template/js/vendor/bootstrap.min.js", "defer" => "defer"],
          "template/js/plugins/swiper-bundle.min.js",
          "template/js/plugins/glightbox.min.js",
          "template/js/script.js"
    ];
    public $depends = [
         'yii\web\YiiAsset',
    ];
}
