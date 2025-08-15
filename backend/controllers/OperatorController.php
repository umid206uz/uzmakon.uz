<?php

namespace backend\controllers;

use common\models\OperatorOrders;
use common\models\Orders;
use common\models\User;
use common\models\OperatorSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class OperatorController extends Controller
{
    public function behaviors(): array
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

    public function actionIndex(): string
    {
        $searchModel = new OperatorSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id): string
    {
        $counts = Orders::find()
            ->select(['status', 'COUNT(*) AS cnt'])
            ->where(['operator_id' => $id])
            ->groupBy('status')
            ->indexBy('status')
            ->asArray()
            ->all();

        $getCount = function($status) use ($counts) {
            return isset($counts[$status]) ? (int)$counts[$status]['cnt'] : 0;
        };

        return $this->render('view', [
            'model'                       => $this->findModel($id),
            'new_order_count'             => $getCount(Orders::STATUS_NEW),
            'delivered_order_count'       => $getCount(Orders::STATUS_DELIVERED),
            'being_delivered_order_count' => $getCount(Orders::STATUS_BEING_DELIVERED),
            'read_to_delivery_order_count'=> $getCount(Orders::STATUS_READY_TO_DELIVERY),
            'black_list_order_count'      => $getCount(Orders::STATUS_BLACK_LIST),
            'hold_order_count'            => $getCount(Orders::STATUS_HOLD),
            'preparing_count'              => $getCount(Orders::STATUS_PREPARING),
            'returned_order_count'         => $getCount(Orders::STATUS_RETURNED_OPERATOR),
            'come_back_count'              => $getCount(Orders::STATUS_RETURNED),
            'then_takes_back_count'        => $getCount(Orders::STATUS_THEN_TAKES),
        ]);
    }

    public function actionChangePassword($id)
    {
        $model = User::findOne($id);

        $model->phone_operator = $model->tell;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->setPassword($model->new_pass_operator);
            $model->save();
            $text = Yii::$app->params['og_site_name']['content'] . " Sizning parol o'zgartirildi. Yangi parol: " . $model->new_pass_operator;
            $model->phone_operator = Yii::$app->formatter->cleanPhone($model->phone_operator);
            $response = Yii::$app->sms->sendSms($model->phone_operator, $text);
            if ($response && $response->status == "token-invalid"){
                Yii::$app->sms->sendTokenSms();
                Yii::$app->sms->sendSms($this->username, $text);
            }
            Yii::$app->getSession()->setFlash('success', Yii::t("app",'Data changed successfully'));
            $this->redirect(['view', 'id' => $id]);
        }
        return $this->renderAjax('change-password', [
            'model' => $model
        ]);
    }

    public function actionChangePayment($id)
    {
        $model = User::findOne($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            Yii::$app->getSession()->setFlash('success', Yii::t("app",'Data changed successfully'));
            $this->redirect(['view', 'id' => $id]);
        }
        return $this->renderAjax('change-payment', [
            'model' => $model
        ]);
    }

    public function actionHistoryBalance($id): string
    {
        $model = $this->findModel($id);
        $dataProvider = new ActiveDataProvider([
            'query' => OperatorOrders::find()->where(['operator_id' => $id])->orderBy(['order_id' => SORT_DESC]),
        ]);

        return $this->render('history-balance', [
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
