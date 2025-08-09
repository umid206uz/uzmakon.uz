<?php

namespace frontend\controllers;

use common\models\Setting;
use common\models\Orders;
use common\models\Oqim;
use common\models\Pages;
use common\models\Product;
use common\models\User;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\authclient\ClientInterface;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }

    public function onAuthSuccess(ClientInterface $client)
    {
        $attributes = $client->getUserAttributes();

        $email = ArrayHelper::getValue($attributes,'email');
        $given_name = ArrayHelper::getValue($attributes,'given_name');
        $family_name = ArrayHelper::getValue($attributes,'family_name');
        $photo = ArrayHelper::getValue($attributes,'picture');

        $user = User::findOne(['email' => $email]);

        if (!$user) {
            $user = new User();
            $user->username = $given_name . time();
            $user->first_name = $given_name;
            $user->last_name = $family_name;
            $user->filename = $photo;
            $user->email = $email;
            $user->access_token = rand(100000, 999999) . time();
            $user->setPassword(Yii::$app->security->generateRandomString());
            $user->generateAuthKey();
            $user->generateEmailVerificationToken();
            $user->save();
        }

        Yii::$app->user->login($user, 3600 * 24 * 2);

        echo "<script>
                window.opener.location.href = '" . Url::to(['/main'], true) . "';
                window.close();
            </script>";
        exit;
    }

    public function actionIndex()
    {
        $setting = Setting::findOne(1);
        $seo = Pages::findOne(1);

        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => $seo->metaDescriptionTranslate,
        ]);

        Yii::$app->params['og_title']['content'] = $seo->metaTitleTranslate;
        Yii::$app->params['og_description']['content'] = $seo->metaDescriptionTranslate;
        Yii::$app->params['og_image']['content'] = Yii::$app->request->hostInfo . '/backend/web/uploads/' . $setting->open_graph_photo;

        $query = Product::find()->where(['status' => 1])->orderBy(['id' => SORT_DESC])->limit(12);
        $model = $query->all();

        return $this->render('index', [
            'seo' => $seo,
            'setting' => $setting,
            'model' => $model,
            'counts' => $query->count()
        ]);
    }

    public function actionLoadMore($offset): string
    {
        $products = Product::find()
            ->where(['status' => 1])
            ->orderBy(['id' => SORT_DESC])
            ->offset($offset)
            ->limit(12)
            ->all();

        return $this->renderPartial('_product_items', ['model' => $products]);
    }
    
    public function actionSearch()
    {

        $key = Yii::$app->request->get('key');
        if(Yii::$app->request->get('key')){
            $query = Product::find()
            ->where(['like', 'title', $key])
            ->orWhere(['like', 'title_ru', $key])
            ->orWhere(['like', 'title_en', $key])
            ->orWhere(['like', 'description', $key])
            ->orWhere(['like', 'description_ru', $key])
            ->orWhere(['like', 'description_en', $key])
            ->andWhere(['status' => 1]);
        }else{
            $query = Product::find()->where(['status' => 1]);
        }

        $pages = New Pagination(['totalCount' => $query->count(), 'pageSize' => 9, 'forcePageParam' => false, 'pageSizeParam' => false]);
        $products = $query->offset($pages->offset)->limit($pages->limit)->all();


        return $this->render('search',[
            'model' => $products,
            'pagination' => $pages,
            'counts' => $query->count(),
            "count" => $query->count(),
            'key' => $key,
        ]);
    }

    public function actionProduct($id)
    {
        $product = Product::findOne($id);

        if($product == null){
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $model = new Orders();

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->insertNew($product)) {

            Yii::$app->session->setFlash('success', Yii::t("app", "Thank you! Your order has been successfully accepted!"));

            return $this->redirect(Yii::$app->request->referrer);
        }

        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => $product->metaDescriptionTranslate
        ]);

        Yii::$app->params['og_title']['content'] = $product->metaTitleTranslate;
        Yii::$app->params['og_description']['content'] = $product->metaDescriptionTranslate;
        Yii::$app->params['og_language_uz']['content'] = '/uz/product/' . $product->id;
        Yii::$app->params['og_language_ru']['content'] = '/ru/product/' . $product->id;
        Yii::$app->params['og_language_en']['content'] = '/en/product/' . $product->id;
        Yii::$app->params['og_url']['content'] = Yii::$app->request->hostInfo . '/product/' . $product->id;
        Yii::$app->params['og_type']['content'] = 'product';

        if(isset($product->photo->filename)){
            Yii::$app->params['og_image']['content'] = Yii::$app->request->hostInfo . '/backend/web/uploads/product/' . $product->photo->filename;
        }else{
            Yii::$app->params['og_image']['content'] = Yii::$app->request->hostInfo . '/backend/web/uploads/product/no.png';
        }

        return $this->render('product',[
            'product' => $product,
            'model' => $model,
        ]);

    }

    public function actionLink($url)
    {
        $model = new Orders();

        $stream = Oqim::findOne(['key' => $url]);

        $product = Product::findOne($stream->product_id);

        if($product == null || $stream == null){
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->InsertNew($product, $stream)) {

            Yii::$app->session->setFlash('success', Yii::t("app", "Thank you! Your order has been successfully accepted!"));

            if ($model->user->status_new == 1){
                $model->SendStatusTelegram("buyurtma tushdi.");
            }
            
            return $this->redirect(Yii::$app->request->referrer);
        }

        $stream->CreateClick();

        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => $product->metaDescriptionTranslate,
        ]);

        Yii::$app->params['og_title']['content'] = $product->metaTitleTranslate;
        Yii::$app->params['og_description']['content'] = $product->metaDescriptionTranslate;
        Yii::$app->params['og_language_uz']['content'] = '/uz/link/' . $url;
        Yii::$app->params['og_language_ru']['content'] = '/ru/link/' . $url;
        Yii::$app->params['og_language_en']['content'] = '/en/link/' . $url;
        Yii::$app->params['og_url']['content'] = Yii::$app->request->hostInfo . '/link/' . $url;
        Yii::$app->params['og_type']['content'] = 'link';

        if(isset($product->photo->filename)){
            Yii::$app->params['og_image']['content'] = Yii::$app->request->hostInfo . '/backend/web/uploads/product/' . $product->photo->filename;
        }else{
            Yii::$app->params['og_image']['content'] = Yii::$app->request->hostInfo . '/backend/web/uploads/product/no.png';
        }

        return $this->render('link',[
            'product' => $product,
            'model' => $model,
        ]);

    }
}
