<?php

use common\components\Bot;
use common\components\Sms;
use common\components\Status;
use common\components\FormatterHelper;
use yii\mutex\MysqlMutex;
use yii\queue\db\Queue;

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'modules' => [
        'gii' => [
            'class' => 'yii\gii\Module',
            'allowedIPs' => ['93.188.85.202', '::1']
        ],
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'queue' => [
            'class' => Queue::class,
            'db' => 'db',
            'tableName' => '{{%queue}}',
            'channel' => 'default',
            'mutex' => MysqlMutex::class,
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'bot' => [
            'class' => Bot::class,
        ],
        'sms' => [
            'class' => Sms::class,
        ],
        'status' => [
            'class' => Status::class,
        ],
        'formatter' => [
            'class' => FormatterHelper::class
        ]
    ],
];
