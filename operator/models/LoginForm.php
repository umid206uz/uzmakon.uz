<?php
namespace operator\models;

use common\models\Setting;
use Yii;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username'], 'required', 'message' => Yii::t("app", "Enter your login!")],
            [['password'], 'required', 'message' => Yii::t("app", "Enter your password!")],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
            ['password', 'validateRole'],
            ['password', 'validateWork'],
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
                $this->addError($attribute, 'Login yoki parol xato!.');
            }
        }
    }

    public function validateRole($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            $allowedRoles = ['operator_returned', 'operator'];
            if (!$user->role || !in_array($user->role->item_name, $allowedRoles)) {
                $this->addError($attribute, Yii::t("app", "Please wait for admin confirmation!"));
            }
        }
    }

    public function validateWork($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $model = Setting::findOne(1);
            if (!$model || $model->switch == 0) {
                $this->addError($attribute, Yii::t("app", "The working time is over"));
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
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 0 : 0);
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
}
