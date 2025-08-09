<?php

namespace admin\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        "template/css/style.css"
    ];
    public $js = [
        "template/vendor/global/global.min.js",
        "template/js/custom.min.js",
        "template/js/deznav-init.js",
        "template/js/demo.js",
    ];
    public $depends = [
        'yii\web\YiiAsset'
    ];
}
