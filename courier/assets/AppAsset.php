<?php

namespace courier\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
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
        "template/layouts/layout/css/layout.min.css",
        "template/layouts/layout/css/themes/darkblue.min.css",
        "template/layouts/layout/css/custom.min.css",
        "template/css/toastr.min.css"
    ];
    public $js = [
        "template/global/plugins/bootstrap/js/bootstrap.min.js",
        "template/global/plugins/js.cookie.min.js",
        "template/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js",
        "template/global/plugins/jquery.blockui.min.js",
        "template/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js",
        "template/global/scripts/app.min.js",
        "template/layouts/layout/scripts/layout.min.js",
        "template/layouts/layout/scripts/demo.min.js",
        "template/layouts/global/scripts/quick-sidebar.min.js",
        "template/css/toastr.min.js"
    ];
    public $depends = [
        'yii\web\YiiAsset'
    ];
}
