<?php

namespace courier\controllers;

use common\models\OperatorPayment;
use common\models\Orders;
use courier\models\SignupForm;
use courier\models\User;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use courier\models\LoginForm;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post', 'get'],
                ],
            ],
        ];
    }
    
    public function beforeAction($action)
    {
        $allowedRoles = ['courier', 'helper'];
        $user = User::findOne(Yii::$app->user->id);
        if(!$user || !$user->role || !in_array($user->role->item_name, $allowedRoles)) {
            Yii::$app->user->logout();
        }

        return parent::beforeAction($action);
    }

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
        ];
    }

    public function actionIndex(){
        
        $query = Orders::find()->where(['status' => Orders::STATUS_BEING_DELIVERED, 'courier_id' => Yii::$app->user->id])->orderBy(['id' => SORT_DESC]);

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 12]);
        $model = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('index', [
            'model' => $model,
            'pagination' => $pages,
            'counts' => $query->count()
        ]);
    }

    public function actionWork(){

        $query = Orders::find()->where(['status' => Orders::STATUS_BEING_DELIVERED, 'courier_id' => Yii::$app->user->id])->orderBy(['id' => SORT_DESC]);

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 12]);
        $model = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('work', [
            'model' => $model,
            'pagination' => $pages,
            'counts' => $query->count()
        ]);
    }

    public function actionSearch()
    {

        $key = Yii::$app->request->get('key');
        if(Yii::$app->request->get('key')){
            $query = Orders::find()
                ->where(['like', 'id', $key])
                ->orWhere(['like', 'phone', $key])
                ->orWhere(['like', 'full_name', $key])
                ->andWhere(['courier_id' => Yii::$app->user->id]);
        }

        $pages = New Pagination(['totalCount' => $query->count(), 'pageSize' => 12, 'forcePageParam' => false, 'pageSizeParam' => false]);
        $model = $query->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render('search',[
            'model' => $model,
            'pagination' => $pages,
            'counts' => $query->count(),
            'key' => $key,
        ]);
    }

    public function actionAccount()
    {
        $model = User::findOne(Yii::$app->user->id);
        $model->scenario = 'account';
        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {

            $model->picture = UploadedFile::getInstance($model, 'picture');

            if($model->picture) {
                if($model->filename != '' && file_exists("uploads/user/" . $model->filename)){
                    unlink("uploads/user/".$model->filename);
                }
                $model->filename = (microtime(true) * 10000) . "." . $model->picture->extension;
                $model->picture->saveAS("uploads/user/" . $model->filename);
            }

            if(!empty($model->oldpass) && !empty($model->newpass) && !empty($model->repeatnewpass)){
                $model->setPassword($model->newpass);
            }

            if ($model->save()) {
                Yii::$app->getSession()->setFlash('success', \Yii::t("app",'Data changed successfully'));
                return $this->redirect(['/site/account']);
            }
        }
        return $this->render('account',[
            'model' => $model,
        ]);
    }

    public function actionPayment()
    {
        $model = OperatorPayment::find()->where(['operator_id' => Yii::$app->user->id])->all();
        $models = new OperatorPayment();
        $models->operator_id = Yii::$app->user->id;
        if ($models->load(Yii::$app->request->post()) && $models->validate())
        {
            if ($models->operator->card == ''){
                $models->addError('user_id', "Iltimos Profil menyusidan shaxsiy plastik kartangizni kiriting!");
                return $this->render('payment', [
                    'model' => $model,
                    'models' => $models,

                ]);
            }
            $models->created_date = time();
            $models->operator_id = Yii::$app->user->id;
            $models->status = 0;
            $models->save(false);
            Yii::$app->getSession()->setFlash('success', \Yii::t("app",'So`rov muvaffaqiyatli yuborildi'));
            return $this->redirect(['/site/payment']);
        }
        return $this->render('payment', [
            'model' => $model,
            'models' => $models,

        ]);
    }

    public function actionOrdered()
    {
        $query = Orders::find()->where(['status' => Orders::STATUS_DELIVERED, 'courier_id' => Yii::$app->user->id])->orderBy(['id' => SORT_DESC]);

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 12]);
        $model = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('ordered', [
            'model' => $model,
            'pagination' => $pages,
            'counts' => $query->count()
        ]);
    }

    public function actionConfirm($id)
    {
        $order = Orders::findOne(['qr_code' => $id]);
        $user = User::findOne(Yii::$app->user->id);

        if (!$order){
            throw new NotFoundHttpException(Yii::t("app","The requested order does not exist."));
        }

        if ($user->role->item_name == 'courier'){
            if($order == null || $order->courier_id != Yii::$app->user->id){
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        }

        return $this->render('confirm',[
            'model' => $order,
        ]);
    }

    public function actionComeBack()
    {
        $query = Orders::find()->where(['status' => Orders::STATUS_RETURNED, 'courier_id' => Yii::$app->user->id])->orderBy(['id' => SORT_DESC]);

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 12]);
        $model = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('come-back', [
            'model' => $model,
            'pagination' => $pages,
            'counts' => $query->count()
        ]);
    }

    public function actionOrderComplete($id, $status)
    {
        $order = Orders::findOne($id);
        $user = User::findOne(Yii::$app->user->id);
        if ($user->role->item_name == 'helper'){
            if ($id && $status){
                $order->status = $status;
                $order->save();
                if (!$order->validate()){
                    dd($order);
                }
                Yii::$app->session->setFlash('success', 'Status o`zgartirildi');
            }else{
                Yii::$app->session->setFlash('success', 'Nimadir xato!');
            }
        }elseif ($user->role->item_name == 'courier'){
            if ($id && $status && $order->courier_id == Yii::$app->user->id){
                $order->status = $status;
                $order->save();
                Yii::$app->session->setFlash('success', 'Status o`zgartirildi');
            }else{
                Yii::$app->session->setFlash('success', 'Nimadir xato!');
            }
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionLogin()
    {
        $this->layout = 'login';

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            return $this->goHome();

        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionSignup()
    {
        $this->layout = 'login';
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }
}
