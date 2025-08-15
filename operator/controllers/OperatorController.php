<?php

namespace operator\controllers;

use common\models\Orders;
use common\models\OrdersReturn;
use common\models\Regions;
use common\models\Setting;
use operator\models\User;
use yii\web\Controller;
use yii\filters\AccessControl;
use operator\models\UpdateForm;
use yii\data\Pagination;
use yii\web\Response;
use Yii;

/**
 * Site controller
 */
class OperatorController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['operator']
                    ]
                ]
            ]
        ];
    }

    public function beforeAction($action): bool
    {
        $user = User::findOne(Yii::$app->user->id);
        $model = Setting::findOne(1);
        $allowedRoles = ['operator'];
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

    public function actionIndex(): string
    {
        $query = Orders::find()->where(['status' => Orders::STATUS_NEW, 'operator_id' => null])->orWhere(['status' => Orders::STATUS_NEW, 'operator_id' => Yii::$app->user->id])->orderBy(['id' => SORT_DESC]);

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

    protected function findOrdersByStatus(int $status, int $pageSize = 12): array
    {
        $query = Orders::find()->where([
            'operator_id' => Yii::$app->user->id,
            'status' => $status
        ])->orderBy(['id' => SORT_DESC]);

        $countQuery = clone $query;
        $pagination = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => $pageSize]);

        return [
            'orders' => $query->offset($pagination->offset)->limit($pagination->limit)->all(),
            'pagination' => $pagination,
            'count' => $countQuery->count(),
        ];
    }

    public function actionApply(): string
    {
        $result = $this->findOrdersByStatus(Orders::STATUS_NEW);

        return $this->render('apply', [
            'model' => $result['orders'],
            'pagination' => $result['pagination'],
            'counts' => $result['count'],
        ]);
    }

    public function actionOrderComplete(): string
    {
        $result = $this->findOrdersByStatus(Orders::STATUS_READY_TO_DELIVERY);

        return $this->render('order-complete', [
            'model' => $result['orders'],
            'pagination' => $result['pagination'],
            'counts' => $result['count'],
        ]);
    }

    public function actionHold(): string
    {
        $result = $this->findOrdersByStatus(Orders::STATUS_HOLD);

        return $this->render('hold', [
            'model' => $result['orders'],
            'pagination' => $result['pagination'],
            'counts' => $result['count'],
        ]);
    }

    public function actionOrdering(): string
    {
        $result = $this->findOrdersByStatus(Orders::STATUS_BEING_DELIVERED);

        return $this->render('ordering', [
            'model' => $result['orders'],
            'pagination' => $result['pagination'],
            'counts' => $result['count'],
        ]);
    }

    public function actionOrdered(): string
    {
        $result = $this->findOrdersByStatus(Orders::STATUS_DELIVERED);

        return $this->render('ordered', [
            'model' => $result['orders'],
            'pagination' => $result['pagination'],
            'counts' => $result['count'],
        ]);
    }

    public function actionWaiting(): string
    {
        $result = $this->findOrdersByStatus(Orders::STATUS_THEN_TAKES);

        return $this->render('waiting', [
            'model' => $result['orders'],
            'pagination' => $result['pagination'],
            'counts' => $result['count'],
        ]);
    }

    public function actionComeBack(): string
    {
        $result = $this->findOrdersByStatus(Orders::STATUS_RETURNED_OPERATOR);

        return $this->render('come-back', [
            'model' => $result['orders'],
            'pagination' => $result['pagination'],
            'counts' => $result['count'],
        ]);
    }

    public function actionBlackList(): string
    {
        $result = $this->findOrdersByStatus(Orders::STATUS_BLACK_LIST);

        return $this->render('black-list', [
            'model' => $result['orders'],
            'pagination' => $result['pagination'],
            'counts' => $result['count'],
        ]);
    }

    public function actionFeedback(): string
    {
        $result = $this->findOrdersByStatus(Orders::STATUS_FEEDBACK);

        return $this->render('feedback', [
            'model' => $result['orders'],
            'pagination' => $result['pagination'],
            'counts' => $result['count'],
        ]);
    }

    public function actionReturned(): string
    {
        $result = $this->findOrdersByStatus(Orders::STATUS_RETURNED);

        return $this->render('returned', [
            'model' => $result['orders'],
            'pagination' => $result['pagination'],
            'counts' => $result['count'],
        ]);
    }

    public function actionOrderDetail($id): string
    {
        return $this->renderAjax('order-detail', [
            'model' => Orders::findOne($id)
        ]);
    }

    public function actionOrderAjax(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $check = Orders::find()->where(['operator_id' => Yii::$app->user->id, 'status' => Orders::STATUS_NEW])->count();
        if($check > 4){
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
                Yii::$app->session->setFlash('success', 'Status o`zgartirildi');
                return $this->redirect(Yii::$app->request->referrer);
            }else {
                Yii::$app->session->setFlash('success', 'Nimadir xato!');
                return $this->redirect(Yii::$app->request->referrer);
            }
        }

        return $this->renderAjax('ajax', [
            'model' => $model,
            'order' => $order,
        ]);
    }

    public function actionSearch(): string
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
}