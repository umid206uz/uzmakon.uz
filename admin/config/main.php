<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-admin',
    'timeZone' => 'Asia/Tashkent',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules' => [
        'gridview' => [
            'class' => 'kartik\grid\Module'
        ]
    ],
    'controllerNamespace' => 'admin\controllers',
    'language'  => 'uz',
    'components' => [
        'view' => [
            'class' => 'admin\components\View'
        ],
        'request' => [
            'baseUrl' => '',
            'csrfParam' => '_csrf-admin'
        ],
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'sourcePath' => null,
                    'js' => [
                        "template/vendor/global/global.min.js",
                    ]
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => []
                ]
            ]
        ],
        'user' => [
            'identityClass' => 'admin\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
            'loginUrl' => ['site/login-phone'],
        ],
        'session' => [
            'name' => 'advanced-admin'
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
                'charity-payment' => 'site/charity-payment',
                'order-history' => 'site/order-history',
                'orders-by-stream' => 'site/orders-by-stream',
                'competition' => 'site/competition',
                'edit' => 'site/edit',
                'login-phone' => 'site/login-phone',
                'login-password' => 'site/login-password',
                'request-password-reset' => 'site/request-password-reset',
                'signup' => 'site/signup',
                'offers' => 'site/offers',
                'streams' => 'site/streams',
                'orders' => 'site/orders',
                'insert-orders' => 'site/insert-orders',
                '/offer-detail/<id:[a-zA-Z0-9-]+>/'=>'site/offer-detail',
                'offer-category/<id:[a-zA-Z0-9-]+>/' => '/site/offer-category',
                '/reset-password/<token:[a-zA-Z0-9-]+>/'=>'site/reset-password',
                'code/<user:[a-zA-Z0-9-]+>/' => 'site/code',
                '/order/<status:[a-zA-Z0-9-]+>/'=>'site/order',
                '<controller:\w+>/<action:\w+>/<lang\d+>/<id\d+>/<hash\d+>' => '<controller>/<action>',
            ]
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/translations',
                    'sourceLanguage' => 'en',
                ]
            ]
        ]
    ],
    'as beforeRequest' => [
        'class' => 'yii\filters\AccessControl',
        'rules' => [
            [
                'controllers' => ['site'],
                'actions' =>
                    [
                        'signup', 'code', 'reset-verification-code',
                        'login-password', 'request-password-reset',
                        'reset-password', 'verify-email', 'login-phone'
                    ],
                'roles' => ['?'],
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