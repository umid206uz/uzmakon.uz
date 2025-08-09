<?php

namespace backend\controllers;

use common\models\OperatorOrdersSearch;
use common\models\OperatorPayment;
use common\models\OperatorOrders;
use common\models\OperatorPaymentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;

class OperatorPaymentController extends Controller
{
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

    public function actionIndex()
    {
        $searchModel = new OperatorPaymentSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        if(Yii::$app->request->post('hasEditable')){
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $placeId = Yii::$app->request->post('editableKey');
            $place = $this->findModel($placeId);
            $post = [];
            $posted = current($_POST['OperatorPayment']);
            $post['OperatorPayment'] = $posted;
            if($place->load($post) && $place !== null){
                $place->payed_date = time();
                $place->save(false);
                $amount = $place->amount;
                if ($place->status == 1){
                    $model = OperatorOrders::find()->where(['operator_id' => $place->operator_id, 'status' => OperatorOrders::STATUS_NOT_PAID])->all();
                    $model1 = OperatorOrders::find()->where(['operator_id' => $place->operator_id, 'status' => OperatorOrders::STATUS_NOT_PAID])->sum('amount');
                    if ($model1 == $place->amount) {
                        foreach ($model as $item){
                            $item->status = 1;
                            $item->payed_date = time();
                            $item->save(false);
                        }
                    }else{
                        foreach ($model as $item){
                            if($item->amount < $amount){
                                $item->status = 1;
                                $item->payed_date = time();
                                $item->save(false);
                                if ($item->debit == OperatorOrders::DEBIT_RIGHT){
                                    $amount = $amount - $item->amount;
                                }else{
                                    $amount = $amount + $item->amount;
                                }
                            }elseif ($item->amount == $amount){
                                $item->status = 1;
                                $item->payed_date = time();
                                $item->save(false);
                                if ($item->debit == OperatorOrders::DEBIT_RIGHT){
                                    break;
                                }
                                $amount = $amount + $item->amount;
                            }
                            else{
                                $item->status = 0;
                                $item->payed_date = time();
                                if ($item->debit == OperatorOrders::DEBIT_RIGHT){
                                    $item->amount = $item->amount - $amount;
                                    $item->save(false);
                                    break;
                                }
                                $amount = $amount + $item->amount;
                                $item->save(false);
                            }
                        }
                    }
                }
            }
            return ['output' => '', 'message'=>''];
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $model = OperatorPayment::findOne($id);

        $searchModel = new OperatorOrdersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $model->operator_id);

        return $this->render('view', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'model' => $model,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = OperatorPayment::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
