<?php

namespace backend\controllers;

use common\models\OrdersReturnSearch;
use yii\web\Controller;
use yii\filters\VerbFilter;

/**
 * OrdersReturnController implements the CRUD actions for OrdersReturn model.
 */
class OrdersReturnController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all OrdersReturn models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrdersReturnSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
