<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-mini',
    'timeZone' => 'Asia/Tashkent',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules' => [
        'gridview' => [
            'class' => 'kartik\grid\Module'
        ]
    ],
    'controllerNamespace' => 'mini\controllers',
    'language'  => 'uz',
    'components' => [
        'view' => [
            'class' => 'mini\components\View'
        ],
        'request' => [
            'baseUrl' => '',
            'csrfParam' => '_csrf-frontend'
        ],
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'sourcePath' => null,
                    'js' => [
                        'template/global/plugins/jquery.min.js'
                    ]
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => []
                ]
            ]
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true]
        ],
        'session' => [
            'name' => 'advanced-frontend'
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning']
                ]
            ]
        ],
        'errorHandler' => [
            'errorAction' => 'site/error'
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'search' => 'site/search',
                'account' => 'site/account',
                'payment' => 'site/payment',
                'login' => 'site/login',
                'signup' => 'site/signup',
                'waiting' => 'site/waiting',
                'ordered' => 'site/ordered',
                'feedback' => 'site/feedback',
                'ordering' => 'site/ordering',
                'returned' => 'site/returned',
                'create-order' => 'site/create-order',
                'order-history' => 'site/order-history',
                'order-complete' => 'site/order-complete',
                'come-back' => 'site/come-back',
                'black-list' => 'site/black-list',
                'create-product/<id:[a-zA-Z0-9-]+>/' => 'site/create-product',
                'hold' => 'site/hold',
                '<controller:\w+>/<action:\w+>/<lang\d+>/<id\d+>/<hash\d+>' => '<controller>/<action>',
            ]
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/translations',
                    'sourceLanguage' => 'en'
                ]
            ]
        ]
    ],
    'as beforeRequest' => [
        'class' => 'yii\filters\AccessControl',
        'rules' => [
            [
                'controllers' => ['site'],
                'actions' => ['login', 'signup', 'logout'],
                'roles' => ['?','@'],
                'allow' => true
            ],
            [
                'allow' => true,
                'roles' => ['@']
            ]
        ]
    ],
    'params' => $params
];