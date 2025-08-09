<?php

namespace backend\controllers;

use Yii;
use common\models\Brand;
use common\models\BrandSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
/**
 * BrandController implements the CRUD actions for Brand model.
 */
class BrandController extends BackendController
{
    public function actionIndex()
    {
        $searchModel = new BrandSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
	    if(Yii::$app->request->post('hasEditable')){
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $placeId = Yii::$app->request->post('editableKey');
            $place = $this->findModel($placeId);
            $post = [];
            $posted = current($_POST['Brand']);
            $post['Brand'] = $posted;
            if($place->load($post)){
                $place->save();
            }
            return ['output' => $place->status, 'message'=>''];
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionDownload($id) 
      { 
        $download = Brand::findOne($id); 
        $path="uploads/brand/". $download->filename;
     
        if (file_exists($path)) {
            return Yii::$app->response->sendFile($path);

        }
    }

    public function actionCreate()
    {
        $model = new Brand();

        if ($model->load(Yii::$app->request->post())) {
		$model->status = 0;
		$model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
    
    public function actionModal($id){

        date_default_timezone_set("Asia/Tashkent");
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $picture = UploadedFile::getInstance($model, 'picture');

            if($picture){
                
                $rasmModel = Brand::findOne($id);
                if(!empty($rasmModel->filename)){

                    unlink("uploads/brand/".$rasmModel->filename);

                }
                
                $model->filename = (microtime(true) * 10000).".". $picture->extension;

                $picture->saveAS("uploads/brand/". $model->filename);
            } 
            $model->save(false);
            return $this->redirect(['index']);
        }

        return $this->renderAjax('modal', [
            'model' => $model,
        ]);

    }

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

    public function actionDelete($id)
    {
        $model = Brand::findOne($id);

        $this->findModel($id)->delete();

        if(file_exists("uploads/brand/".$model->filename)){
            unlink("uploads/brand/".$model->filename);
        }

        \Yii::$app->getSession()->setFlash('danger', "O'chirildi!");

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Brand::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
