<?php

use yii\mutex\MysqlMutex;
use yii\queue\db\Queue;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'queue'],
    'controllerNamespace' => 'console\controllers',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'controllerMap' => [
        'fixture' => [
            'class' => 'yii\console\controllers\FixtureController',
            'namespace' => 'common\fixtures',
          ],
            'migrate' => [
                'class' => 'yii\console\controllers\MigrateController',
                'migrationPath' => null,
                'migrationNamespaces' => [
                    'yii\queue\db\migrations'
                ]
            ]
    ],
    'components' => [
        'queue' => [
            'class' => Queue::class,
            'db' => 'db',
            'tableName' => '{{%queue}}',
            'channel' => 'default',
            'mutex' => MysqlMutex::class
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager'
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning']
                ]
            ]
        ]
    ],
    'params' => $params,
];
