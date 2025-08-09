<?php
namespace api\controllers;

use yii\web\Response;
use yii\rest\Controller;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;

class ConfigController extends Controller
{
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        unset($actions['view']);
        unset($actions['update']);
        unset($actions['delete']);
        return $actions;
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // add CORS filter
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::class,
        ];

        $behaviors['formats'] =
        [
            'class' => 'yii\filters\ContentNegotiator',
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];

//        $behaviors['authenticator'] = [
//            'class' => CompositeAuth::class,
//            'authMethods' => [
//                HttpBasicAuth::class,
//                HttpBearerAuth::class,
//            ],
//        ];

        return $behaviors;
    }
}