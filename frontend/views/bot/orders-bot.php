<?php

/* @var $orders_bot_token common\models\Setting */

use common\models\Telegram;
define('API_KEY', $orders_bot_token);

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

$keyboard = json_encode([
    'resize_keyboard' => true,
    'keyboard' => [
        [['text' => "Ижара"], ['text' => "Сотув"],],
    ]
]);

if(isset($tx)){
    ty($cid);
}
$full_name = '';
if($tx == "/start"){
    bot('sendMessage', [
        'chat_id'=>$cid,
        'text'=>"Добро пожаловать! Введите ваше имя и фамилию",
    ]);
}
if (isset($tx) && $tx != "/start") {
    if(strlen($tx) < 11)
    {
        bot('sendMessage', [
            'chat_id' => $cid,
            'text' => "Пожалуйста, введите правильно ваше имя и фамилию!",
            'parse_mode' => 'markdown',
        ]);
    }else{
        $user = Telegram::findOne(['user_chat_id' => $cid]);
        if($user->user_chat_id != $cid){
            $telegram_user = new Telegram();
            $telegram_user->user_chat_id = $cid;
            $telegram_user->full_name = $tx;
            $telegram_user->status = 0;
            if($telegram_user->save(false)){
                bot('sendMessage', [
                    'chat_id' => $cid,
                    'text' => "Поздравляю! вы зарегистрировались, пожалуйста, свяжитесь с администратором",
                    'parse_mode' => 'markdown',
                ]);
            }else{
                bot('sendMessage', [
                    'chat_id' => $cid,
                    'text' => "Nimadur xato",
                    'parse_mode' => 'markdown',
                ]);
            }
        }else{
            bot('sendMessage', [
                'chat_id' => $cid,
                'text' => "Вы уже зарегистрированы, обратитесь к администратору.",
                'parse_mode' => 'markdown',
            ]);
        }
    }
}
?>