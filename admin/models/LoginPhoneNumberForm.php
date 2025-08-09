<?php
namespace admin\models;

use Yii;
use yii\base\Model;
/**
 * LoginPhoneNumberForm model
 *
 * @property integer $phone_number
 * @property integer $verification_code
 */

class LoginPhoneNumberForm extends Model
{
    public $phone_number;
    public $verification_code;

    private $_user;

    public function rules()
    {
        return [
            ['phone_number', 'required', 'message' => Yii::t("app","Please enter a phone number!")],
            ['verification_code', 'required', 'message' => Yii::t("app","Please enter code!")],
            ['verification_code', 'integer', 'message' => Yii::t("app","Code must be an integer.")],
            ['verification_code', 'validateVerificationCode'],
            ['phone_number', 'checkPhoneNUmber'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'phone_number' => Yii::t('app','Phone number'),
            'verification_code' => Yii::t('app','Code'),
        ];
    }

    public function beforeValidate(): bool
    {
        $this->phone_number = (integer) strtr($this->phone_number, [
            '+998' => '',
            '-' => '',
            '(' => '',
            ')' => '',
            ' ' => '',
            '_' => '',
        ]);

        return parent::beforeValidate();
    }

    public function checkPhoneNUmber($attribute, $params){
        if(strlen($this->phone_number) < 9) {
            $this->addError($attribute, Yii::t("app",'Please enter the correct phone number!'));
        }
    }

    public function validateVerificationCode($attribute, $params)
    {
        $user = $this->getUser();
        if (!$user || !$user->validateVerificationCode($this->verification_code)) {
            $this->addError($attribute, Yii::t("app","The code entered is incorrect!"));
        }
    }

    public function login(): bool
    {
        if ($this->validate(['verification_code'])) {
            return Yii::$app->user->login($this->getUser(), 3600*24*30);
        }
        return false;
    }

    public function sendSms(): bool
    {
        $user = $this->getUser();
        $code = rand(1000, 999999);
        $text = Yii::$app->params['og_site_name']['content'] . " saytiga kirish uchun tasdiqlash kodi: " . $code . " kodni hechkimga bermang! uni faqat firibgarlar so'raydi.";
        if ($user === null) {
            $user = new User();
            $user->username = $this->phone_number . time();
            $user->tell = $this->phone_number;
            $user->access_token = rand(100000, 999999) . time();
            $user->email = $this->phone_number . '@gmail.com';
            $user->status = User::STATUS_ACTIVE;
            $user->setPassword($this->phone_number . $code);
            $user->generateAuthKey();
            $user->generateEmailVerificationToken();
            $user->save();
            $text = Yii::$app->params['og_site_name']['content'] . " saytiga ro'yxatdan o'tish uchun tasdiqlash kodi: " . $code . ". Muvaffaqiyatli ro'yxatdan o'tdingiz. Sizning Login: " . $user->username . " Parol: " . $this->phone_number . $code . " login va parolni profil bo'limidan almashtirishni unutmang!";
        }
        $user->setVerificationCode($code);
        $user->save(false);
        $response = Yii::$app->sms->sendSms($this->phone_number, $text);
//        dd($response);
        if ($response && isset($response->message) && $response->message == "Expired"){
            Yii::$app->sms->sendTokenSms();
        }
        return true;
    }

    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findOne(['tell' => $this->phone_number, 'status' => User::STATUS_ACTIVE]);
        }
        return $this->_user;
    }
}
