<?php

namespace backend\controllers;

use common\models\Orders;
use common\models\OrdersPrepare;
use common\models\OrdersPrepareSearch;
use common\models\User;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OrdersPrepareController implements the CRUD actions for OrdersPrepare model.
 */
class OrdersPrepareController extends Controller
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
     * Lists all OrdersPrepare models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new OrdersPrepareSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'user' => User::findOne(Yii::$app->user->id)
        ]);
    }

    public function actionOrderUpdate(){

        $searchModel = new OrdersPrepareSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->post('selection'));
        if (Yii::$app->request->post()['state_2'] == 2){
            foreach ($dataProvider->getModels() as $item) {
                $item->order->status = Orders::STATUS_RETURNED;
                $item->order_status = Orders::STATUS_RETURNED;
                $item->order->save(false);
                $item->status = 1;
                $item->time = time();
                $item->save(false);
            }
            return $this->redirect(Yii::$app->request->referrer);
        }elseif (Yii::$app->request->post()['state_2'] == 3){
            foreach ($dataProvider->getModels() as $item) {
                $item->order->status = Orders::STATUS_DELIVERED;
                $item->order_status = Orders::STATUS_DELIVERED;
                $item->order->save(false);
                $item->status = 1;
                $item->time = time();
                $item->save(false);
            }
            return $this->redirect(Yii::$app->request->referrer);
        }elseif (Yii::$app->request->post()['state_2'] == 4){
            foreach ($dataProvider->getModels() as $item) {
                $item->order->status = Orders::STATUS_NEW;
                $item->order_status = Orders::STATUS_NEW;
                $item->order->save(false);
                $item->status = 1;
                $item->time = time();
                $item->save(false);
            }
            return $this->redirect(Yii::$app->request->referrer);
        }elseif (Yii::$app->request->post()['state_2'] == 5){
            foreach ($dataProvider->getModels() as $item) {
                $item->order->status = Orders::STATUS_FEEDBACK;
                $item->order_status = Orders::STATUS_FEEDBACK;
                $item->order->save(false);
                $item->status = 1;
                $item->time = time();
                $item->save(false);
            }
            return $this->redirect(Yii::$app->request->referrer);
        }elseif (Yii::$app->request->post()['state_3']){
            foreach ($dataProvider->getModels() as $item) {
                $item->order->courier_id = Yii::$app->request->post()['state_3'];
                if ($item->order->status != Orders::STATUS_BEING_DELIVERED){
                    $item->order_status = Orders::STATUS_BEING_DELIVERED;
                    $item->order->status = Orders::STATUS_BEING_DELIVERED;
                }
                $item->order->save(false);
                $item->status = 1;
                $item->time = time();
                $item->save(false);
            }
            return $this->redirect(Yii::$app->request->referrer);
        }else{
            return $this->redirect(Yii::$app->request->referrer);
        }
    }

    /**
     * Finds the OrdersPrepare model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return OrdersPrepare the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OrdersPrepare::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
