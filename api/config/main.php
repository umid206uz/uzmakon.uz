<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-api',
    'language' => 'uz',
    'timeZone' => 'Asia/Tashkent',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',
    'bootstrap' => ['log'],
    'modules' => [
    ],
    'components' => [

        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
            'csrfParam' => '_csrf-api',
            'baseUrl' => ""
        ],

        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'enableSession' => false,
            'loginUrl' => null,
            'identityCookie' => ['name' => '_identity-api', 'httpOnly' => true]
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
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                'auth' => 'site/login' ,
                'create' => 'order/index' ,
                'test' => 'order/test' ,
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => [
                        'user',
                        'site',
                        'order'
                    ]
                ]
            ]
        ],

        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/translations',
                    'sourceLanguage' => 'en',
                ],
                'yii' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/translations',
                    'sourceLanguage' => 'en'
                ]
            ]
        ]
    ],

    'params' => $params,
];
