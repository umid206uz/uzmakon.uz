<?php

/* @var $get_order_bot_token common\models\Setting */
/* @var $model common\models\Product */

use common\models\Oqim;
use common\models\OrderBot;

define('API_KEY', $get_order_bot_token);

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
// if($tx){
//
//     bot('sendMessage', [
//         'chat_id'=>$cid,
//         'parse_mode' => 'html',
//         'text'=> $tx,
//     ]);
// }
// exit();
$key = strtr($tx, [
    '/start ' => '',
]);
$model = Oqim::findOne(['key' => $key])->product;
$stream = Oqim::findOne(['key' => $key]);
$user = OrderBot::findOne(['user_chat_id' => $cid, 'status' => 0]);
if (empty($user)){
    $user = new OrderBot();
    $user->user_chat_id = $cid;
    $user->time = time();
    $user->save(false);
}
if ($model && $model->id != $user->product_id){
    $user->step = 0;
    $user->full_name = null;
    $user->time = time();
    $user->save(false);
}
if ($user->step == 0){
    if ($model){
        if ($model->filename == ''){
            $path = Yii::$app->request->hostInfo . '/backend/web/uploads/product/'.$model->photo->filename;
        }
        else{
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
        $text .= '.....................' . "\n";
        $text .= 'Ushbu mahsulotga buyurtma berish uchun quyida bot orqali beriladigan savollar javob bering.';

        $user->step = 1;
        $user->product_id = $model->id;
        $user->stream_id = $stream->id;
        $user->admin_id = $stream->user_id;
        $user->save(false);
        if ($model->filename == ''){
            bot('sendPhoto', [
                'chat_id'=>$cid,
                'photo'=> $path,
                'caption' => $text,
            ]);
            bot('sendMessage', [
                'chat_id'=>$cid,
                'parse_mode' => 'html',
                'text' => 'Ismingizni kiriting!',
                'reply_markup' => $user->keyboardCancel
            ]);
        }
        else{
            bot('sendVideo', [
                'chat_id'=>$cid,
                'video'=> $path,
                'caption' => $text,
            ]);
            bot('sendMessage', [
                'chat_id'=>$cid,
                'parse_mode' => 'html',
                'text' => 'Ismingizni kiriting!',
                'reply_markup' => $user->keyboardCancel
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
elseif($user->step == 1){
    if ($tx == "❌ Bekor qilish"){
        $user->status = 4;
        $user->save(false);
        bot('sendMessage', [
            'chat_id'=>$cid,
            'parse_mode' => 'html',
            'text' => 'Buyurtma bekor qilindi 😞 Raxmat!',
            'reply_markup' => $user->keyboardError
        ]);
        exit();
    }
    $user->full_name = $tx;
    $user->step = 2;
    $user->save(false);
    bot('sendMessage', [
        'chat_id'=>$cid,
        'parse_mode' => 'html',
        'text' => 'Telefon raqamingizni «+998 XX XXX XX XX» koʼrinishida kiriting yoki «📞 Raqamni joʼnatish» tugmasi orqali telefon raqamingizni yuboring.',
        'reply_markup' => $user->keyboardPhone
    ]);
}
elseif($user->step == 2){
    if ($tx == "⬅️ Ortga"){
        $user->step = 1;
        $user->full_name = null;
        $user->save(false);
        bot('sendMessage', [
            'chat_id'=>$cid,
            'parse_mode' => 'html',
            'text' => 'Ismingizni kiriting!',
            'reply_markup' => $user->keyboardCancel
        ]);
        exit();
    }
    if ($phone){
        $user->phone = $phone;
    }
    else{
        $tx = (int) $tx;
        $tx = strtr($tx, [
            '+998' => '',
            '-' => '',
            '(' => '',
            ')' => '',
            ' ' => '',
            '_' => '',
        ]);
        if (strlen($tx) > 6){
            $user->phone = $tx;
        }else{
            bot('sendMessage', [
                'chat_id'=>$cid,
                'parse_mode' => 'html',
                'text' => 'Iltimos telefon raqamingizni «+998 XX XXX XX XX» koʼrinishida kiriting yoki «📞 Raqamni joʼnatish» tugmasi orqali telefon raqamingizni yuboring.',
                'reply_markup' => $user->keyboardPhone
            ]);

            exit();
        }
    }

    $user->step = 3;
    $user->save(false);
    $user->insertOrder();
    bot('sendMessage', [
        'chat_id'=>$cid,
        'parse_mode' => 'html',
        'text' => 'Buyurtma qabul qilindi! 🥳 Tez orada operatorlarimiz siz bilan bog`lanishadi!',
        'reply_markup' => $user->keyboardSuccess
    ]);
}
?>