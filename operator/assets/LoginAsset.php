<?php

namespace operator\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class LoginAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        "template/global/plugins/font-awesome/css/font-awesome.min.css",
        "template/global/plugins/simple-line-icons/simple-line-icons.min.css",
        "template/global/plugins/bootstrap/css/bootstrap.min.css",
        "template/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css",
        "template/global/css/components-rounded.min.css",
        "template/global/css/plugins.min.css",
        "template/pages/css/login-4.min.css",
    ];
    public $js = [
        "template/global/plugins/bootstrap/js/bootstrap.min.js",
        "template/global/plugins/js.cookie.min.js",
        "template/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js",
        "template/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js",
        "template/global/plugins/jquery.blockui.min.js",
        "template/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js",
        "template/global/plugins/jquery-validation/js/jquery.validate.min.js",
        "template/global/plugins/jquery-validation/js/additional-methods.min.js",
        "template/global/plugins/select2/js/select2.full.min.js",
        "template/global/plugins/backstretch/jquery.backstretch.min.js",
        "template/global/scripts/app.min.js",
        "template/pages/scripts/login-4.min.js",
    ];
    public $depends = [
        'yii\web\YiiAsset'
    ];
}
