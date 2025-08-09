<?php

namespace backend\controllers;

use common\models\OrdersPrepare;
use Mpdf\Mpdf;
use Yii;
use common\models\Orders;
use common\models\OrdersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

class OrdersController extends Controller
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

    public function actionIndex(): string
    {
        $searchModel = new OrdersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDailyProduct(): string
    {
        $model = Orders::find()->select(['COUNT(*) AS count', 'product_id'])->where(['status' => Orders::STATUS_READY_TO_DELIVERY])->groupBy('product_id')->orderBy(['count' => SORT_DESC])->all();
        return $this->render('daily-product', [
            'model' => $model,
        ]);
    }

    public function actionStatus($id)
    {
        $model = Orders::findOne($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->operator_id = ($model->status == Orders::STATUS_NEW) ? null : $model->operator_id;
            $model->save();
            $this->redirect(Yii::$app->request->referrer);
        }
        return $this->renderAjax('status', [
            'model' => $model,
            'id' => $id

        ]);
    }

    public function actionPdf(array $params){

        $searchModel = new OrdersSearch();
        $dataProvider = $searchModel->search($params);
        $html = $this->renderPartial('pdf', ['searchModel' => $searchModel,'dataProvider' => $dataProvider]);
        $mpdf = new Mpdf();
        $mpdf->showImageErrors = true;
        $mpdf->curlAllowUnsafeSslRequests = true;
        $mpdf->SetDisplayMode('fullpage', 'two');
        $mpdf->list_indent_first_level = 0;
        $mpdf->writeHtml($html);
        $mpdf->Output();
        exit;

    }

    public function actionPdfAction(){
        ini_set('pcre.backtrack_limit', '100000000');
        ini_set('max_execution_time', '3000');
        $searchModel = new OrdersSearch();
        $dataProvider = $searchModel->searchs(Yii::$app->request->post('selection'));
        if (Yii::$app->request->post()['state_2'] == 1){
            foreach ($dataProvider->getModels() as $item)
            {
                $item->status = Orders::STATUS_PREPARING;
                $item->save(false);
            }
            $html = $this->renderPartial('pdf-action', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider]);
        }elseif (Yii::$app->request->post()['state_2'] == 2){
            foreach ($dataProvider->getModels() as $item)
            {
                $item->status = Orders::STATUS_RETURNED;
                $item->save(false);
            }
            return $this->redirect(Yii::$app->request->referrer);
        }elseif (Yii::$app->request->post()['state_2'] == 3){
            foreach ($dataProvider->getModels() as $item)
            {
                $item->status = Orders::STATUS_DELIVERED;
                $item->save(false);
            }
            return $this->redirect(Yii::$app->request->referrer);
        }elseif (Yii::$app->request->post()['state_2'] == 4){
            foreach ($dataProvider->getModels() as $item)
            {
                $item->status = Orders::STATUS_NEW;
                $item->operator_id = null;
                $item->take_time = null;
                $item->save(false);
            }
            return $this->redirect(Yii::$app->request->referrer);
        }
        if (Yii::$app->request->post()['state_2'] == 5){
            foreach ($dataProvider->getModels() as $item)
            {
                $item->status = Orders::STATUS_BEING_DELIVERED;
                $item->save(false);
            }
            $html = $this->renderPartial('pdf-check', ['searchModel' => $searchModel,'dataProvider' => $dataProvider]);
        }elseif(Yii::$app->request->post()['state_2'] == 6){
            foreach ($dataProvider->getModels() as $item)
            {
                $item->status = Orders::STATUS_BEING_DELIVERED;
                $item->save(false);
            }
            $html = $this->renderPartial('pdf-checks', ['searchModel' => $searchModel,'dataProvider' => $dataProvider]);
        }else{
            $html = $this->renderPartial('pdf-action', ['searchModel' => $searchModel,'dataProvider' => $dataProvider]);
        }

        $mpdf = new Mpdf();
        $mpdf->showImageErrors = true;
        $mpdf->SetDisplayMode('fullpage', 'two');
        $mpdf->list_indent_first_level = 0;
        $mpdf->writeHtml($html);
        $mpdf->Output();
        exit;

    }

    public function actionCancelled(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        $code = Yii::$app->request->get('code');
        $order = Orders::findOne(['qr_code' => $code]);
//        dd($order);
        if ($order){
            if ($order->status == Orders::STATUS_BEING_DELIVERED || $order->status == Orders::STATUS_PREPARING){
                $response = (new OrdersPrepare())->createNewRecord($order);
                if ($response){
                    Yii::$app->getSession()->setFlash('success',Yii::t("app",'Qo\'shildi ID: ') . $order->id);
                    return [
                        'status' => 'success',
                        'control' => 1
                    ];
                }else{
                    Yii::$app->getSession()->setFlash('warning',Yii::t("app",'Allaqachon qo\'shilgan ID: ') . $order->id);
                    return [
                        'status' => 'success',
                        'control' => 1
                    ];
                }

            }else{
                Yii::$app->getSession()->setFlash('info',Yii::t("app",'Buyurtma holati xato: ') . Yii::$app->status->statusForPayment($order->status));
                return [
                    'status' => 'success',
                    'control' => 3
                ];
            }
        }else{
            Yii::$app->getSession()->setFlash('danger',Yii::t("app",'Xatolik! ') . $code);
            return [
                'status' => 'success',
                'control' => 0,
                'code' => $code
            ];
        }
    }

    protected function findModel($id)
    {
        if (($model = Orders::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}