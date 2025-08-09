<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-courier',
    'timeZone' => 'Asia/Tashkent',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'courier\controllers',
    'language'  => 'uz',
    'components' => [
        'view' => [
            'class' => 'courier\components\View'
        ],
        'request' => [
            'baseUrl' => '',
            'csrfParam' => '_csrf-courier',
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
                    'css' => [
                    ]
                ]
            ]
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-courier', 'httpOnly' => true]
        ],
        'session' => [
            'name' => 'advanced-courier',
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
                '/confirm/<id:[a-zA-Z0-9-]+>/'=>'site/confirm',
                'ordered' => 'site/ordered',
                'work' => 'site/work',
                'come-back' => 'site/come-back',
                '<controller:\w+>/<action:\w+>/<lang\d+>/<id\d+>/<hash\d+>' => '<controller>/<action>',
            ],
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
