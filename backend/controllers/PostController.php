<?php

namespace backend\controllers;

use Yii;
use common\models\Post;
use common\models\PostSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
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
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if(Yii::$app->request->post('hasEditable')){
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $placeId = Yii::$app->request->post('editableKey');
            $place = $this->findModel($placeId);
            $post = [];
            $posted = current($_POST['Post']);
            $post['Post'] = $posted;
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

    /**
     * Displays a single Post model.
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

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        date_default_timezone_set("Asia/Tashkent");

        $model = new Post();

        if ($model->load(Yii::$app->request->post())) {

                $model->picture = UploadedFile::getInstance($model, 'picture');

            if($model->picture){

                $model->filename = (microtime(true) * 10000).".". $model->picture->extension;
                $model->picture->saveAS("uploads/post/". $model->filename);
                $model->created_date = time();
                $model->status = 1;
                $model->posted_by = Yii::$app->user->identity->id;

                if($model->save(false))
                {
                    \Yii::$app->getSession()->setFlash('success', "Post muvaffaqiyatli qo'shildi!");
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }else{
                \Yii::$app->getSession()->setFlash('danger', "Iltimos rasmni yuklang!");

                $model->addError('picture', "Iltimos rasmni yuklang!");

                return $this->render('create', ['model' => $model]);
            }
            
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        if ($model->load(Yii::$app->request->post())) {

            $picture = UploadedFile::getInstance($model, 'picture');

            if($picture){
                
                $rasmModel = Post::findOne($id);

                if (file_exists("uploads/post/".$rasmModel->filename)){
                    unlink("uploads/post/".$rasmModel->filename);
                }

                $model->filename = (microtime(true) * 10000).".". $picture->extension;
                
                $picture->saveAS("uploads/post/". $model->filename);
            }  
            $model->created_date = time();
            $model->posted_by = Yii::$app->user->identity->id;
            $model->save(false);

            \Yii::$app->getSession()->setFlash('success', "Post muvaffaqiyatli o'zgartirildi!");
            return $this->redirect(['view', 'id' => $id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = Post::findOne($id);

        $this->findModel($id)->delete();

        if(file_exists("uploads/post/".$model->filename)){
            unlink("uploads/post/".$model->filename);
        }

        \Yii::$app->getSession()->setFlash('danger', "o'chirildi!");

        return $this->redirect(['index']);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
