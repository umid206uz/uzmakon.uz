<?php

namespace api\controllers;

use common\models\Oqim;
use common\models\Orders;
use common\models\Product;
use common\models\User;
use api\models\Order;
use Yii;

class OrderController extends ConfigController
{
    public function actionIndex(){

        if (Yii::$app->request->post()){
            if (!isset(Yii::$app->request->post()['api_key']) || Yii::$app->request->post()['api_key'] == ''){
                return [
                    'success' => false,
                    'message' => 'api_key yuborilmadi!'
                ];
            }elseif (!isset(Yii::$app->request->post()['offer_id']) || Yii::$app->request->post()['offer_id'] == ''){
                return [
                    'success' => false,
                    'message' => 'offer_id yuborilmadi!'
                ];
            }elseif (!isset(Yii::$app->request->post()['phone']) || Yii::$app->request->post()['phone'] == ''){
                return [
                    'success' => false,
                    'message' => 'phone yuborilmadi!'
                ];
            }elseif (!isset(Yii::$app->request->post()['name']) || Yii::$app->request->post()['name'] == ''){
                return [
                    'success' => false,
                    'message' => 'name yuborilmadi!'
                ];
            }elseif (!isset(Yii::$app->request->post()['stream']) || Yii::$app->request->post()['stream'] == ''){
                return [
                    'success' => false,
                    'message' => 'stream yuborilmadi!'
                ];
            }else{
                $access_token = Yii::$app->request->post()['api_key'];
                $stream_key = Yii::$app->request->post()['stream'];
                $name = Yii::$app->request->post()['name'];
                $phone = Yii::$app->request->post()['phone'];
                $offer_id = Yii::$app->request->post()['offer_id'];
                $user = User::findOne(['access_token' => $access_token]);
                $stream = Oqim::findOne(['key' => $stream_key]);
                $offer = Product::findOne($offer_id);
                if ($user === null){
                    return [
                        'success' => false,
                        'message' => 'api_key noto\'g\'ri!'
                    ];
                }elseif ($stream === null){
                    return [
                        'success' => false,
                        'message' => 'stream noto\'g\'ri!'
                    ];
                }elseif ($offer === null){
                    return [
                        'success' => false,
                        'message' => 'offer_id noto\'g\'ri!'
                    ];
                }elseif ($stream->user_id != $user->id){
                    return [
                        'success' => false,
                        'message' => 'stream api_key ga mos emas!'
                    ];
                }elseif($stream->product_id != $offer->id){
                    return [
                        'success' => false,
                        'message' => 'stream offer_id ga mos emas!'
                    ];
                }else{
                    $order = new Orders();
                    $order->full_name = $name;
                    $order->phone = $phone;
                    $order->user_id = $user->id;
                    $order->product_id = $offer_id;
                    $order->oqim_id = $stream->id;
                    $order->save(false);
                    return [
                        'ok' => true,
                        'id' => $order->id
                    ];
                }
            }

        }else{
            return "Faqat POST yuborilsin";
        }
    }

    public function actionTest(){
        $model = new Order();
        if ($model->load(Yii::$app->request->post(),'') && $model->validate()){
            return [
                'ok' => true,
                'id' => 1231343123
            ];
        }elseif ($model->hasErrors()){
            return $model->getErrors();
        }else{
            return "Faqat POST yuborilsin";
        }
    }

}