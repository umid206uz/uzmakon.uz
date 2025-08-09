<?php
namespace backend\controllers;

use common\models\AdminOrders;
use common\models\OperatorOrders;
use common\models\SettingSearch;
use common\models\User;
use common\models\Orders;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\AdminLoginForm;
/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        $user = User::findOne(Yii::$app->user->id);
        if(!$user || !$user->assignment || $user->assignment->item_name != 'The Creator') {
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
        ];
    }

    public function actionIndex()
    {
        $new = Orders::find()->where(['status' => Orders::STATUS_NEW])->count();
        $read_to_delivery = Orders::find()->where(['status' => Orders::STATUS_READY_TO_DELIVERY])->count();
        $being_delivered = Orders::find()->where(['status' => Orders::STATUS_BEING_DELIVERED])->count();
        $delivered = Orders::find()->where(['status' => Orders::STATUS_DELIVERED])->count();
        $takes_tomorrow = Orders::find()->where(['status' => Orders::STATUS_THEN_TAKES])->count();
        $returned = Orders::find()->where(['status' => Orders::STATUS_RETURNED])->count();
        $returned_operator = Orders::find()->where(['status' => Orders::STATUS_RETURNED_OPERATOR])->count();
        $black_list = Orders::find()->where(['status' => Orders::STATUS_BLACK_LIST])->count();
        $today_new = Orders::find()->where(['status' => Orders::STATUS_NEW])->andWhere(['between', 'text', strtotime(date('d-m-Y')), strtotime(date('d-m-Y')) + 3600 * 24])->count();
        $today_read_to_delivery = Orders::find()->where(['status' => Orders::STATUS_READY_TO_DELIVERY])->andWhere(['between', 'text', strtotime(date('d-m-Y')), strtotime(date('d-m-Y')) + 3600 * 24])->count();
        $today_being_delivered = Orders::find()->where(['status' => Orders::STATUS_BEING_DELIVERED])->andWhere(['between', 'text', strtotime(date('d-m-Y')), strtotime(date('d-m-Y')) + 3600 * 24])->count();
        $today_delivered = Orders::find()->where(['status' => Orders::STATUS_DELIVERED])->andWhere(['between', 'text', strtotime(date('d-m-Y')), strtotime(date('d-m-Y')) + 3600 * 24])->count();
        $today_takes_tomorrow = Orders::find()->where(['status' => Orders::STATUS_THEN_TAKES])->andWhere(['between', 'text', strtotime(date('d-m-Y')), strtotime(date('d-m-Y')) + 3600 * 24])->count();
        $today_returned = Orders::find()->where(['status' => Orders::STATUS_RETURNED])->andWhere(['between', 'text', strtotime(date('d-m-Y')), strtotime(date('d-m-Y')) + 3600 * 24])->count();
        $today_returned_operator = Orders::find()->where(['status' => Orders::STATUS_RETURNED_OPERATOR])->andWhere(['between', 'text', strtotime(date('d-m-Y')), strtotime(date('d-m-Y')) + 3600 * 24])->count();
        $today_black_list = Orders::find()->where(['status' => Orders::STATUS_BLACK_LIST])->andWhere(['between', 'text', strtotime(date('d-m-Y')), strtotime(date('d-m-Y')) + 3600 * 24])->count();
        $data = Orders::find()->select('region_id, count(*) as litres')->groupBy('region_id')->asArray()->all();
        $daily_data = Orders::find()->select('region_id, count(*) as litres')->where(['between', 'text', strtotime(date('d-m-Y')), strtotime(date('d-m-Y')) + 3600 * 24])->groupBy('region_id')->asArray()->all();
        $paid = AdminOrders::find()->where(['status' => 1])->sum('amount');
        $operator_paid = OperatorOrders::find()->where(['status' => 1])->sum('amount');
        $not_paid = AdminOrders::find()->where(['status' => 0])->sum('amount');
        $operator_not_paid = OperatorOrders::find()->where(['status' => 0])->sum('amount');
        $searchModel = new SettingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'new' => $new,
            'read_to_delivery' => $read_to_delivery,
            'being_delivered' => $being_delivered,
            'delivered' => $delivered,
            'returned' => $returned,
            'takes_tomorrow' => $takes_tomorrow,
            'returned_operator' => $returned_operator,
            'black_list' => $black_list,
            'data' => $data,
            'daily_data' => $daily_data,
            'paid' => $paid,
            'operator_paid' => $operator_paid,
            'not_paid' => $not_paid,
            'operator_not_paid' => $operator_not_paid,
            'today_new' => $today_new,
            'today_read_to_delivery' => $today_read_to_delivery,
            'today_being_delivered' => $today_being_delivered,
            'today_delivered' => $today_delivered,
            'today_takes_tomorrow' => $today_takes_tomorrow,
            'today_returned' => $today_returned,
            'today_returned_operator' => $today_returned_operator,
            'today_black_list' => $today_black_list,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new AdminLoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
