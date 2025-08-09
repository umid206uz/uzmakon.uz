<?php

namespace backend\controllers;

use common\models\AdminOrders;
use common\models\AdminOrderSearch;
use Yii;
use common\models\Payment;
use common\models\PaymentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

class PaymentController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new PaymentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if(Yii::$app->request->post('hasEditable')){
            \Yii::$app->response->format = Response::FORMAT_JSON;
            $placeId = Yii::$app->request->post('editableKey');
            $place = $this->findModel($placeId);
            $post = [];
            $posted = current($_POST['Payment']);
            $post['Payment'] = $posted;
            if($place->load($post) && $place !== null){
                $place->payed_date = time();
                $place->AdminSendTelegram();
                $place->save(false);
                $amount = $place->amount;
                if ($place->status == 1){
                    $model = AdminOrders::find()->where(['admin_id' => $place->user_id, 'status' => AdminOrders::STATUS_NOT_PAID])->all();
                    $model1 = AdminOrders::find()->where(['admin_id' => $place->user_id, 'status' => AdminOrders::STATUS_NOT_PAID])->sum('amount');
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
                                if ($item->debit == AdminOrders::DEBIT_RIGHT){
                                    $amount = $amount - $item->amount;
                                }else{
                                    $amount = $amount + $item->amount;
                                }
                            }elseif ($item->amount == $amount){
                                $item->status = 1;
                                $item->payed_date = time();
                                $item->save(false);
                                if ($item->debit == AdminOrders::DEBIT_RIGHT){
                                    break;
                                }
                                $amount = $amount + $item->amount;
                            }
                            else{
                                $item->status = 0;
                                $item->payed_date = time();
                                if ($item->debit == AdminOrders::DEBIT_RIGHT){
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
        $model = Payment::findOne($id);

        $searchModel = new AdminOrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $model->user_id);

        return $this->render('view', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'model' => $model,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Payment::findOne(['id' => $id, 'status' => 0])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
