<?php

namespace admin\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class LoginAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        "template/css/style.css"
    ];
    public $js = [
        "template/js/custom.min.js",
        "template/js/deznav-init.js"
    ];
    public $depends = [
        'yii\web\YiiAsset'
    ];
}
