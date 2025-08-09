<?php

namespace backend\controllers;

use common\models\Atrcat;
use common\models\Atrpro;
use common\models\Attribute;
use common\models\CountryDeliveryPrice;
use common\models\Category;
use common\models\Tags;
use common\models\TagsPosts;
use common\models\Catpro;
use common\models\Colorpro;
use common\models\Photos;
use Yii;
use common\models\Product;
use common\models\ProductSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;
use yii\web\Response;
use yii\web\UploadedFile;


class ProductController extends BackendController
{
    public function actionIndex()
    {
	date_default_timezone_set("Asia/Tashkent");
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
	    if(Yii::$app->request->post('hasEditable')){
            \Yii::$app->response->format = Response::FORMAT_JSON;
            $placeId = Yii::$app->request->post('editableKey');
            $place = $this->findModel($placeId);
            $post = [];
            $posted = current($_POST['Product']);
            $post['Product'] = $posted;
            if($place->load($post)){
		    $place->created_date = time();
                $place->save();
            }
            return ['output' => '', 'message'=>''];
        }
	
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPhoto($id)
    {
        date_default_timezone_set("Asia/Tashkent");

        $model = new Photos();

        if ($model->load(Yii::$app->request->post())) {

            $imageFiles = UploadedFile::getInstances($model, 'photos');

            if ($imageFiles) {
                foreach ($imageFiles as $file) {

                    $imgName = explode('.', explode(' ', microtime())[0])[1] . '7.' . $file->extension;

                    $photo = new Photos();

                    $photo->filename = $imgName;

                    $photo->product_id = $id;

                    $photo->save();

                    $file->saveAs('uploads/product/' . $imgName);
                }
            }
            \Yii::$app->getSession()->setFlash('success', "фотографии успешно добавлены!");
            return $this->redirect(['view', 'id' => $id]);
        }

        return $this->renderAjax('photo', [
            'model' => $model
        ]);
    }

    public function actionColor($id)
    {
        $model = $this->findModel($id);

        $dataProvider = new ActiveDataProvider([
            'query' => Colorpro::find()->where(['product_id' => $id]),
        ]);

        date_default_timezone_set("Asia/Tashkent");

        if ($model->load(Yii::$app->request->post())) {


            $picture = UploadedFile::getInstance($model, 'picture');

            if($picture){

                $rasmModel = Product::findOne($id);
                if(!empty($rasmModel->filename)){
                    if (file_exists("uploads/product/video/".$rasmModel->filename)) {
                        unlink("uploads/product/video/".$rasmModel->filename);
                    }

                }

                $model->filename = (microtime(true) * 10000).".". $picture->extension;

                $picture->saveAS("uploads/product/video/". $model->filename);
            }
            $model->save(false);
            return $this->redirect(['index']);
        }
        return $this->renderAjax('color', [
            'model' => $model,
            'dataProvider' => $dataProvider,

        ]);
    }

    public function actionCategory($id)
    {
        $model = new Catpro();

        $dataProvider = new ActiveDataProvider([
            'query' => Catpro::find()->where(['product_id' => $id]),
        ]);

        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();
            foreach ($post as $index => $item) {
                if ($index == '_csrf-backend')
                    continue;
                foreach ($item as $value) {
                    foreach ($value as $asd) {
                        $atrPro = new Catpro();
                        $atrPro->category_id = $asd;
                        $atrPro->product_id = $id;
                        $atrPro->save();
                    }
                }
            }
            $this->redirect(['view', 'id' => $id]);
        }
        return $this->renderAjax('category', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'id' => $id

        ]);
    }

    public function actionDeleteColor($id)
    {
        $model = Colorpro::findOne($id);
        $key = $model->product_id;
        if ($model->delete()) {
            return $this->redirect(['view', 'id' => $key]);
        }

    }

    public function actionDeleteCategory($id)
    {
        $model = Catpro::findOne($id);
        $key = $model->product_id;
        if ($model->delete()) {
            return $this->redirect(['view', 'id' => $key]);
        }

    }

    public function actionDel($id)
    {
        $model = Photos::findOne($id);
        $key = $model->product_id;

        if (file_exists("uploads/product/" . $model->filename)) {
            unlink("uploads/product/" . $model->filename);
            $model->delete();
        }

        \Yii::$app->getSession()->setFlash('danger', "фотографии успешно удалена!!");
        return $this->redirect(['view', 'id' => $key]);

    }

    public function actionView($id)
    {
	if(Yii::$app->request->post('hasEditable')){
            \Yii::$app->response->format = Response::FORMAT_JSON;
            $placeId = Yii::$app->request->post('editableKey');
            $place = $this->findModel($placeId);
            $post = [];
            $posted = current($_POST['Product']);
            $post['Product'] = $posted;
            if($place->load($post)){
		$place->created_date = time();
                $place->save();
            }
            return ['output' => $place->status, 'message'=>''];
        }
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionList($query)
    {

        Yii::$app->response->format = Response::FORMAT_JSON;
        $items  = [];
        // $query = urldecode(mb_convert_encoding($query, "UTF-8"));
        foreach(Tags::find()->where(['like', 'name', $query])->asArray()->all() as $tag){
            $items[] = ['keyword' => $tag['name']];
        }
        return $items;
    }

    public function actionCreate()
    {
        $model = new Product();
	    date_default_timezone_set("Asia/Tashkent");
        if ($model->load(Yii::$app->request->post())) {
	    $model->created_date = time();
	    $model->status = 1;
	    $model->user_id = Yii::$app->user->identity->id;
            $model->save();
            if(isset($model->tag) and !empty($model->tag)){
                $tags = explode(',' , $model->tag);
                foreach($tags as $tag){
                    $check_tag = Tags::find()->where(['like', 'name', $tag])->one();
                    if($check_tag!==null){
                        $model2 = new TagsPosts();
                        $model2->post_id = $model->id;
                        $model2->tag_id = $check_tag->id;
                        $model2->save(false);
                    }else{
                        $model3 = new Tags();
                        $model3->name = $tag;
			            $model3->status = 0;
                        $model3->save(false);

                        $model2 = new TagsPosts();
                        $model2->post_id = $model->id;
                        $model2->tag_id = $model3->id;
                        $model2->save(false);
                    }
                }
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $model->created_date = time();
            $model->save();
            if(isset($model->tag) and !empty($model->tag)){
                TagsPosts::deleteAll(['post_id' => $model->id]);
                $tags = explode(',' , $model->tag);
                foreach($tags as $tag){
                    $check_tag = Tags::find()->where(['like', 'name', $tag])->one();
                    if($check_tag!==null){
                        $model2 = new TagsPosts();
                        $model2->post_id = $model->id;
                        $model2->tag_id = $check_tag->id;
                        $model2->save(false);
                    }else{
                        $model3 = new Tags();
                        $model3->name = $tag;
			            $model3->status = 0;
                        $model3->save(false);

                        $model2 = new TagsPosts();
                        $model2->post_id = $model->id;
                        $model2->tag_id = $model3->id;
                        $model2->save(false);
                    }
                }
            }else{
                TagsPosts::deleteAll(['post_id' => $model->id]);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
//        foreach (Photos::find()->where(['product_id' => $id])->all() as $item) {
//            if (file_exists("uploads/product/" . $item->filename)) {
//                unlink("uploads/product/" . $item->filename);
//                $item->delete();
//            }
//        }
//        foreach (TagsPosts::find()->where(['post_id' => $id])->all() as $item) {
//            $item->delete();
//        }
        $this->findModel($id)->Deletes();
        return $this->redirect(['index']);
    }

    public function actionDeleteAttribute($AttributeId)
    {
        $model = Atrpro::findOne($AttributeId);
        $id = Atrpro::findOne($AttributeId)->product_id;
        if ($model->delete()) {
            return $this->redirect(['view', 'id' => $id]);

        }
    }

    public function actionAjax()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        if ($_GET['id']){
            $model = Photos::findOne(['product_id' => $_GET['product_id'], 'status' => 1]);
            if (!empty($model)){
                $model->status = 0;
                $model->save();
            }

            $image = Photos::findOne(['id' => $_GET['id'],]);
            $image->status = 1;
            $image->save();

            return [
                'status' => 'success',
                'respon' => $model->id
            ];
        }
    }

    public function actionCalculate()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        if(isset($_GET['parent_id'])){
            $category = Category::find()->where(['parent_id' => $_GET['parent_id']])->andWhere(['child_id' => null])->all();
        }

        if (isset($_GET['val'])){
            $val = $_GET['val'];
            $category = Category::find()->where(['child_id' => $val])->all();
            if (!empty($category)){
                $status = 1;
            }else{
                $status = 0;
            }
        }
        else{
            $status = 0;
        }


        $qwe = [];
        foreach ($category as $index => $item) {
            $qwe[] = [
                'id' => $item->id,
                'text' => $item->title_ru
            ];
        }

        return [
            'status' => "success",
            'category' => $qwe,
            'stat' => $status
        ];

    }

    public function actionAtrpro($id)
    {
        $product = Product::findOne($id);
        
        $model = CountryDeliveryPrice::findOne(['product_id' => $id]);
        if ($model === null)
        {
            $model = new CountryDeliveryPrice();
        }
        $model->product_id = $product->id;
        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $model->save();
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->renderAjax('atrpro', [

            'model' => $model
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
