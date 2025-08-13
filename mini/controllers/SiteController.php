<?php

namespace mini\controllers;

use common\models\AdditionalProduct;
use common\models\OperatorOrders;
use common\models\OperatorOrdersSearch;
use mini\models\OperatorPayment;
use mini\models\OperatorPaymentSearch;
use common\models\Orders;
use common\models\Setting;
use common\models\Regions;
use mini\models\SignupForm;
use mini\models\User;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use mini\models\LoginForm;
use mini\models\UpdateForm;
use yii\data\Pagination;
use yii\web\Response;
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
        $user = User::findOne(Yii::$app->user->id);
        $model = Setting::findOne(1);
        if(!$user || !$user->role || $user->role->item_name != 'operator' || $model->switch == 0) {
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

    public function actionOrderHistory(): string
    {
        $searchModel = new OperatorOrdersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->id);

        return $this->render('order-history', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndex(): string
    {
        $query = Orders::find()->where(['operator_id' => null, 'status' => Orders::STATUS_NEW,])->orWhere(['operator_id' => Yii::$app->user->id, 'status' => Orders::STATUS_NEW])->orderBy(['id' => SORT_DESC]);

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

    public function actionOrderComplete(): string
    {
        $query = Orders::find()->where(['operator_id' => Yii::$app->user->id, 'status' => Orders::STATUS_READY_TO_DELIVERY])->orderBy(['id' => SORT_DESC]);

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 12]);
        $model = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('order-complete', [
            'model' => $model,
            'pagination' => $pages,
            'counts' => $query->count()
        ]);
    }

    public function actionOrdering(): string
    {
        $query = Orders::find()->where(['operator_id' => Yii::$app->user->id, 'status' => Orders::STATUS_BEING_DELIVERED])->orderBy(['id' => SORT_DESC]);

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 12]);
        $model = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('ordering', [
            'model' => $model,
            'pagination' => $pages,
            'counts' => $query->count()
        ]);
    }

    public function actionWaiting(): string
    {
        $query = Orders::find()->where(['operator_id' => Yii::$app->user->id, 'status' => Orders::STATUS_THEN_TAKES])->orderBy(['id' => SORT_DESC]);

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 12]);
        $model = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('waiting', [
            'model' => $model,
            'pagination' => $pages,
            'counts' => $query->count()
        ]);
    }

    public function actionHold(): string
    {
        $query = Orders::find()->where(['operator_id' => Yii::$app->user->id, 'status' => Orders::STATUS_HOLD])->orderBy(['id' => SORT_DESC]);

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 12]);
        $model = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('hold', [
            'model' => $model,
            'pagination' => $pages,
            'counts' => $query->count()
        ]);
    }

    public function actionComeBack(): string
    {
        $query = Orders::find()->where(['operator_id' => Yii::$app->user->id, 'status' => Orders::STATUS_RETURNED_OPERATOR])->orderBy(['id' => SORT_DESC]);

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

    public function actionReturned(): string
    {
        $query = Orders::find()->where(['operator_id' => Yii::$app->user->id, 'status' => Orders::STATUS_RETURNED])->orderBy(['id' => SORT_DESC]);

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 12]);
        $model = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('returned', [
            'model' => $model,
            'pagination' => $pages,
            'counts' => $query->count()
        ]);
    }

    public function actionOrdered(): string
    {
        $query = Orders::find()->where(['operator_id' => Yii::$app->user->id, 'status' => Orders::STATUS_DELIVERED])->orderBy(['id' => SORT_DESC]);

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

    public function actionFeedback(): string
    {
        $query = Orders::find()->where(['operator_id' => Yii::$app->user->id, 'status' => Orders::STATUS_FEEDBACK])->orderBy(['id' => SORT_DESC]);

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 12]);
        $model = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('feedback', [
            'model' => $model,
            'pagination' => $pages,
            'counts' => $query->count()
        ]);
    }

    public function actionBlackList(): string
    {
        $query = Orders::find()->where(['operator_id' => Yii::$app->user->id, 'status' => Orders::STATUS_BLACK_LIST])->orderBy(['id' => SORT_DESC]);

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 12]);
        $model = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('black-list', [
            'model' => $model,
            'pagination' => $pages,
            'counts' => $query->count()
        ]);
    }

    public function actionOrderAjax(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $check = Orders::find()->where(['operator_id' => Yii::$app->user->id, 'status' => Orders::STATUS_NEW])->count();
        if($check > 2){
            return [
                'status' => 'success',
                'control' => 2
            ];
        }else{
            if (Yii::$app->request->get('order_id')){
                $order_id = Yii::$app->request->get('order_id');
                $model = Orders::findOne($order_id);
                if ($model->operator_id == null){
                    $model->operator_id = Yii::$app->user->id;
                    $model->save(false);
                    return [
                        'status' => 'success',
                        'order_id' => Yii::$app->user->id,
                        'phone' => $model->phone,
                        'phone_mask' => Yii::$app->formatter->asPhone($model->phone),
                        'control' => 1
                    ];
                }else{
                    return [
                        'status' => 'error',
                        'order_id' => $order_id,
                        'control' => 0
                    ];
                }
            }
        }
    }

    public function actionAjax($id)
    {
        $model = new UpdateForm();
        $order = Orders::findOne($id);
        $model->loadOrder($order);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->orderUpdate($order)) {
                Yii::$app->session->setFlash('success',$id);
                return $this->redirect(Yii::$app->request->referrer);
            }else {
                Yii::$app->session->setFlash('success','Nimadir xato!');
                return $this->redirect(Yii::$app->request->referrer);
            }
        }

        return $this->renderAjax('ajax', [
            'model' => $model,
            'order' => $order,
        ]);
    }

    public function actionOrderDetail($id): string
    {
        $model = Orders::findOne($id);

        return $this->renderAjax('order-detail', [
            'model' => $model
        ]);
    }

    public function actionCreateProduct($id)
    {
        $model = new AdditionalProduct();
        $model->order_id = $id;
        if ($model->load(Yii::$app->request->post())) {
            $model->one_price = $model->product->sale;
            $model->total_price = $model->product->sale*$model->count;
            $model->created_date = time();
            $model->save();
            $text = $model->order->country . ' ' . $model->order->comment . ' ' . $model->order->phone . ' Mahsulot-1: ' . $model->order->product->title . ' ' . Yii::$app->formatter->getPrice($model->order->product->sale) . ' Mahsulot-2: ' . $model->product->title . ' ' . Yii::$app->formatter->getPrice($model->product->sale);
            Yii::$app->session->setFlash('success',$text);
            return $this->redirect(Yii::$app->request->referrer);
        }

        return $this->render('create-product', [
            'model' => $model
        ]);
    }

    public function actionCreateOrder()
    {
        $model = new Orders();
        $model->setScenario('create-order');
        if ($model->load(Yii::$app->request->post())){
            $model->operator_id = Yii::$app->user->id;
            $model->status = Orders::STATUS_READY_TO_DELIVERY;
            if ($model->validate() && $model->save()) {
                Yii::$app->session->setFlash('success', $model->id);
                return $this->redirect(Yii::$app->request->referrer);
            }
        }

        return $this->render('create-order', [
            'model' => $model
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
                ->andWhere(['operator_id' => Yii::$app->user->id]);
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
        $balance_debt = OperatorOrders::find()->where(['operator_id' => $model->id, 'status' => OperatorOrders::STATUS_NOT_PAID, 'debit' => OperatorOrders::DEBIT_DEBT])->sum('amount');
        $balance_right = OperatorOrders::find()->where(['operator_id' => $model->id, 'status' => OperatorOrders::STATUS_NOT_PAID, 'debit' => OperatorOrders::DEBIT_RIGHT])->sum('amount');
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
                Yii::$app->getSession()->setFlash('success', Yii::t("app",'Data changed successfully'));
                return $this->redirect(['/site/account']);
            }
        }
        return $this->render('account',[
            'model' => $model,
            'balance_debt' => $balance_debt,
            'balance_right' => $balance_right,
        ]);
    }

    public function actionPayment()
    {
        $model = new OperatorPayment();
        $searchModel = new OperatorPaymentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model->setScenario('create-payment');
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()){
            Yii::$app->getSession()->setFlash('success', Yii::t("app",'Request sent successfully'));
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->render('payment', [
            'model' => $model,
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

    public function actionLogout(): Response
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
