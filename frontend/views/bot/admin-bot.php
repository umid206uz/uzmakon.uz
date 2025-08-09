<?php

/* @var $admin_bot_token common\models\Setting */
/* @var $user common\models\User */

use common\models\AdminOrders;
use common\models\User;

define('API_KEY', $admin_bot_token);

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
//if ($tx){
//    bot('sendMessage', [
//        'chat_id'=>$cid,
//        'parse_mode' => 'html',
//        'text'=> "Bunday foydalanuvchi topilmadi!",
//    ]);
//}
if ($tx == "/profile"){

    $user = User::findOne(['user_chat_id' => $cid]);

    if ($user){

        $balance = AdminOrders::find()
            ->select(['balance_difference' => 'SUM(CASE WHEN debit = :debit_right THEN amount ELSE 0 END) - SUM(CASE WHEN debit = :debit_debt THEN amount ELSE 0 END)',])
            ->where(['admin_id' => Yii::$app->user->id, 'status' => AdminOrders::STATUS_NOT_PAID])
            ->params([':debit_right' => AdminOrders::DEBIT_RIGHT, ':debit_debt' => AdminOrders::DEBIT_DEBT])->scalar();
        $total_balance = AdminOrders::find()->where(['admin_id' => $user->id])->sum('amount');

        $text = '';
        $text .= "Profilingiz haqida ma'lumotlar" . "\n";
        $text .= "ID: " . $user->id . "\n";
        $text .= "Balans: " . number_format($balance) . " summ \n";
        $text .= "Umumiy Balans: " . number_format($total_balance) . " summ \n";
        $text .= "Ism: " . $user->first_name . "\n";
        $text .= "Familiya: " . $user->last_name . "\n";
        $text .= "Telefon / Login: " . $user->tell . "\n";
        bot('sendMessage', [
            'chat_id'=>$cid,
            'parse_mode' => 'html',
            'text'=> $text,
        ]);
        exit();
    }
    else{
        bot('sendMessage', [
            'chat_id'=>$cid,
            'parse_mode' => 'html',
            'text'=> "Bunday foydalanuvchi topilmadi!",
        ]);
        exit();
    }
}
if ($tx == "/activlashtirish"){

    $user = User::findOne(['user_chat_id' => $cid]);
    if ($user){
        if ($user->step == 2){
            bot('sendMessage', [
                'chat_id'=>$cid,
                'parse_mode' => 'html',
                'text'=> "Aktivlashtirish kodini kiriting: Kodni `mening profilim` bo'limidan olishingiz mumkin.",
            ]);
            exit();
        }
        elseif ($user->step == 1){
            $user->step = 2;
            $user->save(false);
            bot('sendMessage', [
                'chat_id'=>$cid,
                'parse_mode' => 'html',
                'text'=> "Aktivlashtirish kodini kiriting: Kodni `mening profilim` bo'limidan olishingiz mumkin.",
            ]);
            exit();
        }
        elseif ($user->step == 3){
            bot('sendMessage', [
                'chat_id'=>$cid,
                'text'=> 'Bot allaqachon aktivlashtirib bo`lingan!',
            ]);
            exit();
        }
        elseif ($user->step == null){
            bot('sendMessage', [
                'chat_id'=>$cid,
                'parse_mode' => 'html',
                'text'=> 'Assalom aleykum, ' . Yii::$app->params['og_site_name']['content'] . ' (For Admin) botiga xush kelibsiz.',
            ]);
            exit();
        }
    }
    else{
        bot('sendMessage', [
            'chat_id'=>$cid,
            'parse_mode' => 'html',
            'text'=> 'Assalom aleykum, ' . Yii::$app->params['og_site_name']['content'] . ' (For Admin) botiga xush kelibsiz. Aktivlashtirish uchun ' . Yii::$app->params['og_site_name']['content'] . ' saytidan `mening profilim` menyusiga kirib botni aktivlashtirishni bosing!',
        ]);
        exit();
    }
}
if($tx){

    $asd = strtr($tx, [
        '/start ' => '',
    ]);

    $model = User::findOne($asd);
    $model1 = User::findOne(['user_chat_id' => $cid]);
    if ($model){

        if ($model->step == null){

            $model->user_chat_id = $cid;
            $model->step = 1;
            $model->save(false);

            bot('sendMessage', [
                'chat_id'=>$cid,
                'parse_mode' => 'html',
                'text'=> 'Assalom aleykum, ' . Yii::$app->params['og_site_name']['content'] . ' (For Admin) botiga xush kelibsiz! Botdan to\'liq foydalanish uchun /activlashtirish komandasi bilan botni aktivlashtiring.',
            ]);
            exit();
        }
        elseif ($model->step == 1){
            bot('sendMessage', [
                'chat_id'=>$cid,
                'parse_mode' => 'html',
                'text'=> 'Assalom aleykum, ' . Yii::$app->params['og_site_name']['content'] . ' (For Admin) botiga xush kelibsiz! Botdan to\'liq foydalanish uchun /activlashtirish komandasi bilan botni aktivlashtiring.',
            ]);
            exit();
        }
        elseif ($model->step == 2){
            if ($model->access_token == $tx)
            {
                $model->step = 3;
                $model->save(false);
                bot('sendMessage', [
                    'chat_id'=>$cid,
                    'text'=> 'Bot aktivlashtirildi!',
                ]);
                exit();
            }else{
                bot('sendMessage', [
                    'chat_id'=>$cid,
                    'text'=> 'Kiritilgan kod xato!',
                ]);
                exit();
            }
        }
        elseif ($model1->step == 3){
            bot('sendMessage', [
                'chat_id'=>$cid,
                'parse_mode' => 'html',
                'text'=> 'Assalom aleykum, ' . Yii::$app->params['og_site_name']['content'] . ' (For Admin) botiga xush kelibsiz.',
            ]);
            exit();
        }

    }
    elseif($model1)
    {
        if($model1->step == 1){
            bot('sendMessage', [
                'chat_id'=>$cid,
                'parse_mode' => 'html',
                'text'=> 'Assalom aleykum, ' . Yii::$app->params['og_site_name']['content'] . ' (For Admin) botiga xush kelibsiz! Botdan to\'liq foydalanish uchun /activlashtirish komandasi bilan botni aktivlashtiring.',
            ]);
            exit();
        }
        elseif ($model1->step == 2){
            if ($model1->access_token == $tx)
            {
                $model1->step = 3;
                $model1->save(false);
                bot('sendMessage', [
                    'chat_id'=>$cid,
                    'text'=> 'Bot aktivlashtirildi!',
                ]);
                exit();
            }else{
                bot('sendMessage', [
                    'chat_id'=>$cid,
                    'text'=> 'Kiritilgan kod xato!',
                ]);
                exit();
            }
        }
        elseif ($model1->step == 3){
            bot('sendMessage', [
                'chat_id'=>$cid,
                'text'=> 'Assalom aleykum, ' . Yii::$app->params['og_site_name']['content'] . ' (For Admin) botiga xush kelibsiz.',
            ]);
            exit();
        }
    }else{
        bot('sendMessage', [
            'chat_id'=>$cid,
            'text'=> 'Assalom aleykum, ' . Yii::$app->params['og_site_name']['content'] . ' (For Admin) botiga xush kelibsiz! Botdan to\'liq foydalanish uchun /activlashtirish komandasi bilan botni aktivlashtiring.',
        ]);
        exit();
    }
}

?>