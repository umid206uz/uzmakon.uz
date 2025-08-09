<?php

namespace common\components;
use common\models\Setting;
use yii\base\Component;

class Sms extends Component
{

    /**.
     * @param $text
     */
    public function sendSms($phone, $text)
    {
        $token = Setting::findOne(1)->sms_token;
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'notify.eskiz.uz/api/message/sms/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('mobile_phone' => '998' . $phone, 'message' => $text, 'from' => '4546','callback_url' => 'https://uzmakon.uz'),
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '. $token .''
            ),
        ));

        $response = curl_exec($curl);

        $response = json_decode($response);

        curl_close($curl);
        return $response;

    }

    public function sendTokenSms()
    {
        $setting = Setting::findOne(1);
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'notify.eskiz.uz/api/auth/login?email=#&password=#',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
        ));

        $response = curl_exec($curl);

        $response = json_decode($response);

        curl_close($curl);

        if (isset($response) && $response && $response->message && $response->message == "token_generated"){
            $setting->sms_token = $response->data->token;
            $setting->save(false);
        }

        return $response;

    }

}
