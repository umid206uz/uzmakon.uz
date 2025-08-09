<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules' => [
    ],
    'language' => 'uz',
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'baseUrl' => ''
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
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
            'class' => 'codemix\localeurls\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'languages' => ['uz', 'ru', 'en'],
            'enableDefaultLanguageUrlCode' => false,
            'enableLanguagePersistence' => true,
            'enableLanguageDetection' => false,
            'rules' => [
        		'sitemap.xml' => 'sitemap/index',
                'product/<id:[a-zA-Z0-9-]+>/' => 'site/product',
                'category/<id:[a-zA-Z0-9-]+>/' => '/site/category',
        		'/product/<id:[a-zA-Z0-9-]+>/'=>'site/product',
        		'/search/<category_id:[a-zA-Z0-9-]+>/'=>'site/search',
                '/link/<url:[a-zA-Z0-9-]+>/'=>'site/link',
        		'<controller:w+>/<id:d+>'=>'<controller>/view',
                '<controller:w+>/<action:w+>/<id:d+>'=>'<controller>/<action>',
                '<controller:w+>/<action:w+>'=>'<controller>/<action>'
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
    'params' => $params,
];
