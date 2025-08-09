<?php

namespace frontend\controllers;

use common\models\Setting;
use yii\web\Controller;

/**
 * Site controller
 */
class BotController extends Controller
{
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;// эта строка для тех, кто пользуется Yii2 - означает, что мы отключаем проверку csrf, которая контролировала, что бы все запросы были от нашего сайта, а не с левых серваков

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

    public function actionAdminBot(): string
    {
        $setting = Setting::findOne(1);
        return $this->render('admin-bot',[
            'admin_bot_token' => $setting->admin_bot_token
        ]);
    }

    public function actionOrdersBot(): string
    {
        $setting = Setting::findOne(1);
        return $this->render('orders-bot',[
            'orders_bot_token' => $setting->orders_bot_token
        ]);
    }

    public function actionPostBot(): string
    {
        $setting = Setting::findOne(1);
        return $this->render('post-bot',[
            'post_bot_token' => $setting->post_bot_token
        ]);
    }

    public function actionGetOrder(): string
    {
        $setting = Setting::findOne(1);
        return $this->render('get-order',[
            'get_order_bot_token' => $setting->get_order_bot_token
        ]);
    }

}
