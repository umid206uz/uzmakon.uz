<?php

namespace operator\controllers;

use common\models\OperatorPayment;
use common\models\OperatorPaymentSearch;
use common\models\Orders;
use common\models\Regions;
use common\models\Setting;
use operator\models\SignupForm;
use operator\models\User;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use operator\models\LoginForm;
use yii\web\Response;
use yii\web\UploadedFile;
use Yii;

/**
 * Site controller
 */
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
                        'roles' => ['?']
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post', 'get']
                ]
            ]
        ];
    }

    public function beforeAction($action)
    {
        $user = User::findOne(Yii::$app->user->id);
        $model = Setting::findOne(1);
        $allowedRoles = ['operator_returned', 'operator'];
        if(!$user || !$user->role || !in_array($user->role->item_name, $allowedRoles) || $model->switch == 0) {
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

    public function actionCreateOrder()
    {
        $model = new Orders();
        $model->setScenario('create-order');
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()){
            Yii::$app->session->setFlash('success', $model->id);
            return $this->redirect(Yii::$app->request->referrer);
        }

        return $this->render('create-order', [
            'model' => $model
        ]);
    }

    public function actionTerritorialAdministrations(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $region_id = $parents[0];
                $out = self::getTerritorialAdministration($region_id);
                return ['output' => $out, 'selected' => ''];
            }
        }
        return ['output' => '', 'selected' => ''];
    }

    private static function getTerritorialAdministration($region_id): array
    {
        return Regions::find()->select('code as id, name')->where(['parent_id' => $region_id])->asArray()->all();
    }

    public function actionAccount()
    {
        $model = User::findOne(Yii::$app->user->id);
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

            $model->tell = strtr($model->tell, [
                '+998' => '',
                '-' => '',
                '(' => '',
                ')' => '',
                ' ' => ''
            ]);

            if ($model->save(false))
            {
                Yii::$app->getSession()->setFlash('success', Yii::t("app",'Data changed successfully'));
                return $this->redirect(['/site/account']);
            }
        }
        return $this->render('account',[
            'model' => $model,
        ]);
    }

    public function actionPayment()
    {
        $searchModel = new OperatorPaymentSearch();
        $searchModel->setScenario('operator-payment-search');
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new OperatorPayment();
        $model->setScenario('create-operator-payment');
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()){
            Yii::$app->getSession()->setFlash('success', Yii::t("app",'Request sent successfully'));
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->render('payment', [
            'new_model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
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

    public function actionLogout(){
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