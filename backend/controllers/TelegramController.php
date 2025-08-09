<?php

namespace backend\controllers;

use common\models\User;
use common\models\BlackList;
use Yii;
use common\models\Telegram;
use common\models\TelegramSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * TelegramController implements the CRUD actions for Telegram model.
 */
class TelegramController extends Controller
{
    /**
     * {@inheritdoc}
     */
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

    /**
     * Lists all Telegram models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TelegramSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Telegram model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionUpdateStatus(){
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $status = Yii::$app->request->post('status');
        $id = Yii::$app->request->post('id');
        $model = $this->findModel($id);
        if($status == 1){
            $model->status = 0;
        }else{
            $model->status = 1;
        }
        
        $model->save(false);
         return [
             'status' => "success"
         ];
    }

    public function actionUpdateBlack(){
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $status = Yii::$app->request->post('status');
        $id = Yii::$app->request->post('id');
        $user = User::findOne($id);

        if ($status == 10){
            $check = BlackList::findOne(['phone_number' => $user->tell]);
            if ($check === null)
            {
                $black = new BlackList();
                $black->phone_number = $user->tell;
                $black->created_date = time();
                if ($black->save(false)){
                    $user->status = 0;
                    $user->save(false);
                    return [
                        'status' => "success",
                    ];
                }

            }
        }elseif ($status == 0){
            $check = BlackList::findOne(['phone_number' => $user->tell]);
            if ($check !== null)
            {
                if ($check->delete()){
                    $user->status = 10;
                    $user->save(false);
                    return [
                        'status' => "success",
                    ];
                }

            }
        }

    }

    /**
     * Creates a new Telegram model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Telegram();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Telegram model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Telegram model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Telegram model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Telegram the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Telegram::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
