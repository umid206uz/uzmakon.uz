<?php

namespace admin\controllers;

use admin\models\AdminOrders;
use admin\models\AdminOrdersSearch;
use admin\models\InsertOrders;
use admin\models\InsertOrdersSearch;
use admin\models\Payment;
use admin\models\PaymentSearch;
use admin\models\OrdersSearch;
use admin\models\Stream;
use admin\models\StreamSearch;
use admin\models\CharityPayment;
use admin\models\CharityPaymentSearch;
use admin\models\AdminCharity;
use admin\models\PasswordResetRequestForm;
use admin\models\ResetPasswordForm;
use admin\models\VerifyEmailForm;
use admin\models\SignupForm;
use admin\models\LoginPasswordForm;
use admin\models\LoginPhoneNumberForm;
use admin\models\User;
use common\models\Category;
use common\models\Orders;
use common\models\Pages;
use common\models\Post;
use common\models\Product;
use common\models\Setting;
use Yii;
use yii\base\InvalidArgumentException;
use yii\data\Pagination;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post', 'get']
                ]
            ]
        ];
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

    public function actionIndex(): string
    {
        $seo = Pages::findOne(1);
        $setting = Setting::findOne(1);
        $userId = Yii::$app->user->id;

        $adminBalance = AdminOrders::find()
            ->where(['admin_id' => $userId, 'status' => AdminOrders::STATUS_NOT_PAID])
            ->select([
                'debt' => "SUM(CASE WHEN debit = " . AdminOrders::DEBIT_DEBT . " THEN amount ELSE 0 END)",
                'right' => "SUM(CASE WHEN debit = " . AdminOrders::DEBIT_RIGHT . " THEN amount ELSE 0 END)"
            ])
            ->asArray()
            ->one();

        $balance = ($adminBalance['right'] ?? 0) - ($adminBalance['debt'] ?? 0);

        $orderStats = Orders::find()
            ->where(['user_id' => $userId])
            ->select([
                'count_order' => 'COUNT(*)',
                'sold_order' => "SUM(CASE WHEN status = " . Orders::STATUS_DELIVERED . " THEN 1 ELSE 0 END)",
                'archive' => "SUM(CASE WHEN status = " . Orders::STATUS_RETURNED_OPERATOR . " THEN 1 ELSE 0 END)",
                'returned' => "SUM(CASE WHEN status = " . Orders::STATUS_RETURNED . " THEN 1 ELSE 0 END)",
                'new' => "SUM(CASE WHEN status = " . Orders::STATUS_NEW . " THEN 1 ELSE 0 END)",
                'ready_to_delivery' => "SUM(CASE WHEN status = " . Orders::STATUS_READY_TO_DELIVERY . " THEN 1 ELSE 0 END)",
                'being_delivered' => "SUM(CASE WHEN status = " . Orders::STATUS_BEING_DELIVERED . " THEN 1 ELSE 0 END)",
                'delivered' => "SUM(CASE WHEN status = " . Orders::STATUS_DELIVERED . " THEN 1 ELSE 0 END)",
                'takes_tomorrow' => "SUM(CASE WHEN status = " . Orders::STATUS_THEN_TAKES . " THEN 1 ELSE 0 END)",
                'black_list' => "SUM(CASE WHEN status = " . Orders::STATUS_BLACK_LIST . " THEN 1 ELSE 0 END)",
                'hold' => "SUM(CASE WHEN status = " . Orders::STATUS_HOLD . " THEN 1 ELSE 0 END)"
            ])
            ->asArray()
            ->one();

        $probable = Orders::find()
            ->joinWith('product')
            ->where(['orders.user_id' => $userId, 'orders.status' => Orders::STATUS_BEING_DELIVERED])
            ->sum('product.pay');

        $top_users = Orders::find()->select(['COUNT(*) AS count', 'user_id'])
            ->where(['status' => Orders::STATUS_DELIVERED])
            ->groupBy(['user_id'])
            ->orderBy(['count' => SORT_DESC])
            ->limit(8)
            ->asArray()
            ->all();

        $top_products = Orders::find()
            ->select(['COUNT(*) AS count', 'product_id'])
            ->where(['status' => Orders::STATUS_DELIVERED])
            ->groupBy(['product_id'])
            ->orderBy(['count' => SORT_DESC])
            ->limit(8)
            ->asArray()
            ->all();

        return $this->render('index', [
            'seo' => $seo,
            'setting' => $setting,
            'balance' => $balance,
            'probable' => $probable,
            'count_order' => $orderStats['count_order'] ?? 0,
            'sold_order' => $orderStats['sold_order'] ?? 0,
            'returned_order' => $orderStats['returned'] ?? 0,
            'archive' => $orderStats['archive'] ?? 0,
            'new' => $orderStats['new'] ?? 0,
            'read_to_delivery' => $orderStats['ready_to_delivery'] ?? 0,
            'being_delivered' => $orderStats['being_delivered'] ?? 0,
            'delivered' => $orderStats['delivered'] ?? 0,
            'takes_tomorrow' => $orderStats['takes_tomorrow'] ?? 0,
            'black_list' => $orderStats['black_list'] ?? 0,
            'hold' => $orderStats['hold'] ?? 0,
            'top_users' => $top_users,
            'top_products' => $top_products,
        ]);
    }

    public function actionOffers(): string
    {
        $query = Product::find()->where(['status' => 1])->orderBy(['id' => SORT_DESC]);
        $category = Category::find()->all();

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 12]);
        $model = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('offers',[
            'model' => $model,
            'pagination' => $pages,
            'category' => $category
        ]);
    }

    public function actionOfferDetail($id)
    {
        $product = Product::findOne($id);

        if($product == null){
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $model = new Stream();

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            Yii::$app->getSession()->setFlash('success', Yii::t("app", "The stream was created successfully!"));
            return $this->redirect(['streams']);
        }

        return $this->render('offer-detail',[
            'product' => $product,
            'model' => $model,
        ]);

    }

    public function actionOfferCategory($id): string
    {
        $categoryItem = Category::findOne($id);

        if($categoryItem == null){
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $query = Product::find()->where(['status' => 1, 'category_id' => $id])->orderBy(['id' => SORT_DESC]);
        $category = Category::find()->all();

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 12]);
        $model = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('offer-category',[
            'model' => $model,
            'pagination' => $pages,
            'category' => $category,
            'categoryItem' => $categoryItem
        ]);
    }

    public function actionOfferSearch(): string
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

        $pages = New Pagination(['totalCount' => $query->count(), 'pageSize' => 12, 'forcePageParam' => false, 'pageSizeParam' => false]);
        $products = $query->offset($pages->offset)->limit($pages->limit)->all();


        return $this->render('offer-search',[
            'model' => $products,
            'pagination' => $pages,
            'counts' => $query->count(),
            "count" => $query->count(),
            'key' => $key,
        ]);
    }

    public function actionStreams(): string
    {
        $model = Stream::find()->where(['user_id' => Yii::$app->user->id, 'status' => Stream::STATUS_ACTIVE])->orderBy(['id' => SORT_DESC])->all();

        return $this->render('streams',[
            'model' => $model
        ]);
    }

    public function actionPayment()
    {
        $searchModel = new PaymentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new Payment();
        $model->setScenario('create-payment');
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            Yii::$app->getSession()->setFlash('success', Yii::t("app",'Request sent successfully'));
            return $this->redirect(Yii::$app->request->referrer);
        }

        return $this->render('payment', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    public function actionOrderHistory(): string
    {
        $searchModel = new AdminOrdersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('order-history', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionInsertOrders(): string
    {
        $searchModel = new InsertOrdersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('insert-orders', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionInsertModal()
    {
        $model = new InsertOrders();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $excel = UploadedFile::getInstance($model,'excel');
            if($excel){
                $model->filename = date('d.m.Y') . time() . "." . $excel->extension;
                $excel->saveAS("uploads/excel/" . $model->filename);
            }
            if ($model->hasErrors()){
                dd($model);
            }
            $model->save();
            Yii::$app->getSession()->setFlash('success', Yii::t("app",'Request sent successfully'));
            return $this->redirect(['insert-orders']);
        }
        return $this->renderAjax('insert-modal', [
            'model' => $model
        ]);
    }

    public function actionDownload($filename)
    {
        $filePath = Yii::getAlias('uploads/excel/') . $filename;

        if (file_exists($filePath)) {
            return Yii::$app->response->sendFile('uploads/excel/' . $filename, $filename);
        } else {
            throw new NotFoundHttpException("Fayl topilmadi.");
        }
    }

    public function actionOrders(): string
    {
        $searchModel = new OrdersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('orders', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }

    public function actionOrder($status): string
    {
        if($status == null){
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $searchModel = new OrdersSearch();
        $searchModel->status = $status;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('order',[
            'status' => $status,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);

    }

    public function actionOrdersByStream(): string
    {
        $searchModel = new StreamSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('orders-by-stream',[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCharityPayment()
    {
        $searchModel = new CharityPaymentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $count_coin = AdminCharity::find()->where(['admin_id' => Yii::$app->user->id, 'status' => AdminCharity::STATUS_NOT_PAID])->count();
        $amount_coin = AdminCharity::find()->where(['admin_id' => Yii::$app->user->id, 'status' => AdminCharity::STATUS_NOT_PAID])->sum('amount');
        $model = new CharityPayment();
        $model->setScenario('create-charity');
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            Yii::$app->getSession()->setFlash('success', Yii::t("app",'Request sent successfully'));
            return $this->redirect(Yii::$app->request->referrer);
        }

        return $this->render('charity-payment', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
            'count_coin' => $count_coin,
            'amount_coin' => $amount_coin
        ]);
    }

    public function actionCompetition()
    {
        $model = Post::find()->where(['status' => 1])->orderBy(['id' => SORT_DESC])->limit(1)->one();

        if($model == null){
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $users = Orders::find()->select(['COUNT(*) AS count', 'user_id'])->where(['status' => 2])->andWhere(['>=', 'text', strtotime(date($model->started_date))])->groupBy(['user_id'])->orderBy(['count' => SORT_DESC])->limit($model->gold)->all();

        return $this->render('competition',[
            'model' => $model,
            'users' => $users
        ]);
    }

    public function actionAccount()
    {
        $model = User::findOne(Yii::$app->user->id);
        $model->scenario = 'account';
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $model->username = Yii::$app->request->post()['User']['username'];
            $model->email = Yii::$app->request->post()['User']['email'];

            if ($model->save()) {
                Yii::$app->getSession()->setFlash('success', Yii::t("app",'Data changed successfully'));
                return $this->redirect(Yii::$app->request->referrer);
            }
        }

        return $this->render('account',[
            'model' => $model
        ]);
    }

    public function actionEdit()
    {
        $model = User::findOne(Yii::$app->user->id);

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            Yii::$app->getSession()->setFlash('success', Yii::t("app",'Data changed successfully'));
            return $this->redirect(Yii::$app->request->referrer);
        }

        return $this->render('edit',[
            'model' => $model
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        $this->layout = 'login';
        $setting = Setting::findOne(1);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', Yii::t("app","Check your email. Password reset link sent"));
                return $this->redirect('login-password');
            }
            Yii::$app->session->setFlash('danger', 'Sorry, we are unable to reset password for the provided email address.');
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
            'setting' => $setting,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        $this->layout = 'login';
        $setting = Setting::findOne(1);

        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            Yii::$app->session->setFlash('danger',$e->getMessage());
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success',Yii::t("app","New password saved."));
            return $this->redirect('login-password');
        }

        return $this->render('resetPassword', [
            'model' => $model,
            'setting' => $setting,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            Yii::$app->session->setFlash('danger',$e->getMessage());
            throw new BadRequestHttpException($e->getMessage());
        }
        if (($user = $model->verifyEmail()) && Yii::$app->user->login($user)) {
            Yii::$app->session->setFlash('success', Yii::t("app","Your email has been confirmed!"));
            return $this->goHome();
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    public function actionSignup()
    {
        $this->layout = 'login';
        $model = new SignupForm();
        $setting = Setting::findOne(1);

        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', Yii::t("app","Thank you for registering. Please confirm your email address, we have sent a message."));
            return $this->redirect('login-password');
        }

        return $this->render('signup', [
            'model' => $model,
            'setting' => $setting,
        ]);
    }

    public function actionLoginPassword()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'login';

        $model = new LoginPasswordForm();

        $setting = Setting::findOne(1);

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            Yii::$app->session->setFlash('success', Yii::t("app", "You have successfully logged in!"));
            return $this->goHome();
        }else {
            $model->password = '';
            return $this->render('login-password', [
                'model' => $model,
                'setting' => $setting,
            ]);
        }
    }

    public function actionLoginPhone()
    {
        $model = new LoginPhoneNumberForm();
        $setting = Setting::findOne(1);
        $this->layout = 'login';
        if (Yii::$app->request->post('action') === 'send-code-button') {
            if ($model->load(Yii::$app->request->post()) && $model->validate(['phone_number']) && $model->sendSms()) {
                Yii::$app->session->set('phone_number', $model->phone_number);
                Yii::$app->session->set('step', 'verify');
                return $this->refresh();
            }
        }

        if (Yii::$app->request->post('action') === 'login-button') {
            if ($model->load(Yii::$app->request->post()) && $model->login()) {
                Yii::$app->session->remove('phone_number');
                Yii::$app->session->remove('step');
                Yii::$app->session->setFlash('success', Yii::t("app", "You have successfully logged in!"));
                return $this->goHome();
            }
        }

        return $this->render('login-phone', [
            'model' => $model,
            'setting' => $setting,
        ]);
    }

    public function actionResetVerificationCode(): Response
    {
        Yii::$app->session->remove('phone_number');
        Yii::$app->session->remove('step');
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionLogout(): Response
    {
        Yii::$app->user->logout();

        return $this->redirect(['site/login']);
    }
}
