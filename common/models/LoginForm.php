<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $code;
    public $rememberMe = true;

    private $_user;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username'], 'required', 'message' => Yii::t("app", "Please enter a phone number!")],
            ['username','checkBlackList'],
            ['code', 'integer', 'message' => Yii::t("app", "Code must be an integer.")],
            ['code', 'required', 'message' => Yii::t("app", "Please enter code!"), 'when' => function($model){
                return ( Yii::$app->controller->action->id == 'code' ) ? true : false;
            }]
        ];
    }

    public function checkBlackList($attribute, $params){
        $this->username = strtr($this->username, [
            '+998' => '',
            '-' => '',
            '(' => '',
            ')' => '',
            ' ' => '',
            '_' => '',
        ]);

        $model = BlackList::findOne(['phone_number' => $this->username]);

        if($model !== null)
        {
            $this->addError($attribute, Yii::t("app",'You are blacklisted!'));
        }

    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }

    public function sendSms(){
        $this->username = strtr($this->username, [
            '+998' => '',
            '-' => '',
            '(' => '',
            ')' => '',
            ' ' => ''
        ]);

        $code = rand(1000, 999999);

        $user = User::findByUsername1($this->username);

        $text = Yii::$app->params['og_site_name']['content'] . " saytiga kirish uchun tasdiqlash kodi: " . $code . " kodni hechkimga bermang! uni faqat firibgarlar so'raydi.";

        if ($user === null) {
            $user = new User();
            $user->username = $this->username . $code;
            $user->tell = $this->username;
            $user->access_token = rand(100000, 999999) . time();
            $user->email = $this->username . '@gmail.com';
            $user->setPassword($this->username . $code);
            $user->generateAuthKey();
            $user->generateEmailVerificationToken();
            $user->save();
            $text = Yii::$app->params['og_site_name']['content'] . " saytiga ro'yxatdan o'tish uchun tasdiqlash kodi: " . $code . ". Muvaffaqiyatli ro'yxatdan o'tdingiz. Sizning Login: " . $user->username . " Parol: " . $user->username . " login va parolni profil bo'limidan almashtirishni unutmang!";
        }

        $user->code = $code;
        $user->save(false);

        $response = Yii::$app->sms->sendSms($this->username, $text);
//        dd($response);
        if ($response && $response->message == "Expired"){
            Yii::$app->sms->sendTokenSms();
            Yii::$app->sms->sendSms($this->username, $text);
        }

        return true;
    }

    public function loginWithCode(){

        $user = User::findByUsername1($this->username);


        if ($user === null) {
            var_dump('user not found');
            return false;
        }

        if ($user->code != $this->code) {
            Yii::$app->session->setFlash('success', \Yii::t("app","The code entered is incorrect!"));
            return false;
        }


        return Yii::$app->user->login($user, $this->rememberMe ? 3600 * 24 * 30 : 0);

    }
}
