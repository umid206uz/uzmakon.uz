<?php

namespace backend\controllers;

use Yii;
use common\models\Category;
use common\models\CategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;


class CategoryController extends Controller
{

    public function actionIndex()
    {
        $searchModel = new CategorySearch();
        $dataProvider = new ActiveDataProvider([
            'query' => Category::find()->where(['parent_id'=> null]),
        ]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id)
        ]);
    }

    public function actionCreate()
    {
        date_default_timezone_set("Asia/Tashkent");

        $model = new Category();

        if ($model->load(Yii::$app->request->post())) {

            $model->picture = UploadedFile::getInstance($model, 'picture');
            if($model->picture){
                $model->filename = (microtime(true) * 10000).".". $model->picture->extension;
                $model->picture->saveAS("uploads/category/". $model->filename);
		        $model->status = 3;
                $model->save(false);
                if($model->save(false)) {
                    \Yii::$app->getSession()->setFlash('success', "Категория успешно добавлена!");
                    return $this->redirect(['index']);
                }
            }else{
                \Yii::$app->getSession()->setFlash('danger', "Пожалуйста, загрузите фото!");

                $model->addError('picture', "Пожалуйста, загрузите фото!");

                return $this->render('create', ['model' => $model]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $picture = UploadedFile::getInstance($model, 'picture');

            if($picture){
                
                $rasmModel = Category::findOne($id);

                if (file_exists("uploads/category/".$rasmModel->filename)){
                    unlink("uploads/category/".$rasmModel->filename);
                }

                $model->filename = (microtime(true) * 10000).".". $picture->extension;
                
                $picture->saveAS("uploads/category/". $model->filename);
            }  
            
            $model->save(false);

            \Yii::$app->getSession()->setFlash('success', "Изменился успешно!");

            return $this->redirect(['view', 'id' => $id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $qwe = $this->findModel($id);
        if(file_exists("uploads/category/".$qwe->filename)){
            unlink("uploads/category/".$qwe->filename);
        }
        $this->findModel($id)->delete();
        \Yii::$app->getSession()->setFlash('danger', Yii::t("app", "Deleted"));
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
