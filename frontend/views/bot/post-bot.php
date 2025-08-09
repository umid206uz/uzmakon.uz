<?php

/* @var $post_bot_token common\models\Setting */
/* @var $model common\models\Product */
/* @var $stream common\models\Oqim */

use common\models\Oqim;

define('API_KEY', $post_bot_token);

header("Content-Type: text/html; charset=UTF-8");

function ty($ch){
    return bot('sendChatAction', [
        'chat_id' => $ch,
        'action' => 'typing',
    ]);
}

function bot($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}
$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$cid = $message->chat->id;
$cidtyp = $message->chat->type;
$miid = $message->message_id;
$name = $message->chat->first_name;
$user = $message->from->username;
$tx = $message->text;
$longitude = $message->location->longitude;
$latitude = $message->location->latitude;
$callback = $update->callback_query;
$mmid = $callback->inline_message_id;
$mes = $callback->message;
$mid = $mes->message_id;
$cmtx = $mes->text;
$mmid = $callback->inline_message_id;
$idd = $callback->message->chat->id;
$cbid = $callback->from->id;
$cbuser = $callback->from->username;
$data = $callback->data;
$phone = $message->contact->phone_number;
$ida = $callback->id;
$cqid = $update->callback_query->id;
$cbins = $callback->chat_instance;
$cbchtyp = $callback->message->chat->type;

if(isset($tx)){
    ty($cid);
}
//if($tx){
//
//    bot('sendMessage', [
//        'chat_id'=>$cid,
//        'parse_mode' => 'html',
//        'text'=> $tx,
//    ]);
//}
if($tx){
    $asd = strtr($tx, [
        '/start ' => '',
    ]);
    $model = Oqim::findOne(['key' => $asd])->product;
    $stream = Oqim::findOne(['key' => $asd]);
    if ($model){
        if ($model->filename == ''){
            $path = Yii::$app->request->hostInfo . '/backend/web/uploads/product/' . $model->photo->filename;
        }else{
            $path = Yii::$app->request->hostInfo . '/backend/web/uploads/product/video/'.$model->filename;
        }

        $model->text_telegram_bot = strtr($model->text_telegram_bot, [
            '<p>' => '',
            '</p>' => '',
            '<br />' => '',
            '<br>' => "\n",
        ]);
        $text = $model->text_telegram_bot . "\n";
        $text .= "🚚 O'zbekiston bo'ylab yetkazib berish bepul!" . "\n";
        $text .= "\n";
        $text .= "Narxi💰 " . $model->number . " so'm - chegirma narxda xarid qiling!" . "\n";
        $text .= "\n";
        $text .= 'Bartafsil:👇 Buyurtma:👇' . "\n";
        $text .= '👉' .Yii::$app->request->hostInfo . '/link/' . $asd;
        if ($stream->link == Oqim::THROUGH_THE_BOT){
            $keyboard = json_encode([
                'resize_keyboard' => true,
                "inline_keyboard" => [
                    [
                        [
                            "text" => "👉 Bot orqali buyurtma berish ✅",
                            "callback_data" => "t.me/umid206",
                            'url' => 'https://telegram.me/UzMakonGetOrderBot?start=' . $asd
                        ]
                    ]
                ]
            ]);
        }
        elseif ($stream->link == Oqim::THROUGH_THE_SITE){
            $keyboard = json_encode([
                'resize_keyboard' => true,
                "inline_keyboard" => [
                    [
                        [
                            "text" => "👉 Batafsil ✅",
                            "callback_data" => "t.me/umid206",
                            'url' => Yii::$app->request->hostInfo . '/link/' . $asd
                        ]
                    ],
                    [
                        [
                            "text" => "👉 Buyurtma berish ✅",
                            "callback_data" => "t.me/umid206",
                            'url' => Yii::$app->request->hostInfo . '/link/' . $asd
                        ]
                    ],
                ]
            ]);
        }
        elseif ($stream->link == Oqim::THROUGH_THE_SITE_AND_THE_BOT){
            $keyboard = json_encode([
                'resize_keyboard' => true,
                "inline_keyboard" => [
                    [
                        [
                            "text" => "👉 Buyurtma berish ✅",
                            "callback_data" => "t.me/umid206",
                            'url' => Yii::$app->request->hostInfo . '/link/' . $asd
                        ]
                    ],
                    [
                        [
                            "text" => "👉 Bot orqali buyurtma berish ✅",
                            "callback_data" => "t.me/umid206",
                            'url' => 'https://telegram.me/UzMakonGetOrderBot?start=' . $asd
                        ]
                    ]
                ]
            ]);
        }
        else{
            $keyboard = json_encode([
                'resize_keyboard' => true,
                "inline_keyboard" => [
                    [
                        [
                            "text" => "👉 Buyurtma berish ✅",
                            "callback_data" => "t.me/umid206",
                            'url' => Yii::$app->request->hostInfo . '/link/' . $asd
                        ]
                    ],
                    [
                        [
                            "text" => "👉 Bot orqali buyurtma berish ✅",
                            "callback_data" => "t.me/umid206",
                            'url' => 'https://telegram.me/UzMakonGetOrderBot?start=' . $asd
                        ]
                    ]
                ]
            ]);
        }
        if ($model->filename == ''){
            bot('sendPhoto', [
                'chat_id'=>$cid,
                'photo'=> $path,
                'caption' => $text,
                'reply_markup' => $keyboard
            ]);
        }else{
            bot('sendVideo', [
                'chat_id'=>$cid,
                'video'=> $path,
                'caption' => $text,
                'reply_markup' => $keyboard
            ]);
        }

    }else
    {
        bot('sendMessage', [
            'chat_id'=>$cid,
            'text'=> 'Bunday mahsulot topilmadi',
        ]);
    }

}
?>