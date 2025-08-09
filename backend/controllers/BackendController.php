<?php
namespace backend\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use Yii;

/**
 * BackendController extends Controller and implements the behaviors() method
 * where you can specify the access control ( AC filter + RBAC) for
 * your controllers and their actions.
 */
class BackendController extends Controller
{
    /**
     * Returns a list of behaviors that this component should behave as.
     * Here we use RBAC in combination with AccessControl filter.
     *
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'controllers' => [
                            'attribute', 'product', 'gallery', 'color',
                            'category', 'brand', 'payment'
                        ],
                        'actions' => [
                            'index', 'view', 'create', 'update', 'delete','modal',
                            'photo', 'color', 'category', 'delete-color', 'del', 'delete-attribute',
                            'ajax', 'calculate', 'icon', 'atrpro', 'download', 'update-modal', 'atr', 'deletew', 'delete-category', 'deletes',
                            'child', 'status'
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        // other rules
                    ],

                ], // rules

            ], // access

            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ], // verbs

        ]; // return

    } // behaviors

} // BackendController