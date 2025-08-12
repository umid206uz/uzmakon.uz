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
            'csrfParam' => '_csrf-mini'
        ],
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'sourcePath' => null,
                    'js' => [
                        'template/global/plugins/jquery.min.js',
                    ]
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => []
                ]
            ]
        ],
        'user' => [
            'class' => 'mini\components\WebUser',
            'identityClass' => 'mini\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-mini', 'httpOnly' => true]
        ],
        'session' => [
            'name' => 'advanced-mini'
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
        'authManager' => [
            'class' => 'yii\rbac\DbManager'
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'search' => 'site/search',
                'account' => 'site/account',
                'payment' => 'site/payment',
                'login' => 'site/login',
                'apply' => 'site/apply',
                'signup' => 'site/signup',
                'waiting' => 'site/waiting',
                'ordered' => 'site/ordered',
                'returned' => 'site/returned',
                'feedback' => 'site/feedback',
                'order-detail' => 'site/order-detail',
                'create-order' => 'site/create-order',
                'ordering' => 'site/ordering',
                'order-complete' => 'site/order-complete',
                'come-back' => 'site/come-back',
                'black-list' => 'site/black-list',
                'hold' => 'site/hold',
                '<controller:\w+>/<action:\w+>/<lang\d+>/<id\d+>/<hash\d+>' => '<controller>/<action>'
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