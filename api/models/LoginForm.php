<?php
namespace api\models;
use common\library\sms\models\Sms;
use common\models\User;
use common\library\sms\SMSApiPlayMobile;
use Yii;
use yii\base\BaseObject;
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
            [['password'], 'required'],
            [['username'], 'required', 'message' => Yii::t("app", "Please enter a phone number!")],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            ['code', 'integer', 'message' => Yii::t("app", "Code must be an integer.")],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        $user = $this->getUser();
        if ($this->validate()) {
            $token = Yii::$app->security->generateRandomString();
            $user->access_token = $token;
            return $user->save() ? $token : null;
        }
    
        return false;
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
        // var_dump($code);
        // die();
        $user = User::findByUsername1($this->username);

        if ($user === null) {
            $user = new User();
            $user->username = time() . time() . $code;
            $user->tell = $this->username;
            $user->email = $this->username;
            $user->setPassword($this->username);
            $user->generateAuthKey();
            $user->generateEmailVerificationToken();
            $user->save();
        }

        $user->code = $code;
        $user->save(false);
        $sms = new SMSApiPlayMobile();
        $data = [
            [
                'recipient' => '998' . $this->username,
                'priority' => Sms::PRIORITY_REALTIME,
                'text' => "Ваш код: " . $code,
                'status' => Sms::STATUS_VERIFIED,
            ],
        ];
        $sms->prepareSMS($data);
        $sms->sendRequest();
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


        return Yii::$app->user->login($user, $this->rememberMe ? 3600 * 24 * 1 : 0);

    }
}
