<?php

namespace common\components;

use common\models\Setting;
use common\models\Telegram;
use yii\base\Component;

class Bot extends Component
{

    /**.
     * @param $text
     */
    public function sendOrdersBot($text)
    {
        $users = Telegram::find()->where(['status' => 1])->all();
        $bot_token = Setting::findOne(1)->orders_bot_token;

        if(!empty($users)){
            foreach($users as $user1){
                $this->bot($bot_token,'sendMessage', [
                    'chat_id' => $user1->user_chat_id,
                    'text' => $text,
                    'parse_mode' => 'markdown',
                ]);
            }
        }

        return true;
    }

    public function sendAdminBot($text, $chat_id)
    {
        $bot_token = Setting::findOne(1)->admin_bot_token;

        $this->bot($bot_token,'sendMessage', [
            'chat_id' => $chat_id,
            'text' => $text,
            'parse_mode' => 'markdown',
        ]);

        return true;
    }

    public function bot($api_key, $method, $datas=[]){
        $url = "https://api.telegram.org/bot".$api_key."/".$method;
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

}
