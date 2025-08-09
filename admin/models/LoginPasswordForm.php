<?php

namespace admin\models;

use Yii;
use yii\base\Model;

/**
 * LoginPassword form
 */
class LoginPasswordForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = false;

    private $_user;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username'], 'required', 'message' => Yii::t("app", "Enter your login!")],
            [['password'], 'required', 'message' => Yii::t("app", "Enter your password!")],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
//            ['password', 'validateRole']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app','Username'),
            'password' => Yii::t('app','Password'),
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
                if ($this->getUserInactive()){
                    $this->addError($attribute, Yii::t("app","Confirm your email."));
                }
                $this->addError($attribute, Yii::t("app","Incorrect username or password."));
            }
        }
    }

    public function validateRole($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user->assignment || $user->assignment->item_name != 'user') {
                $this->addError($attribute, Yii::t("app","Please wait for admin confirmation!"));
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login(): bool
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 1 : 3600 * 1);
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

    protected function getUserInactive()
    {
        return User::findByUsernameInactive($this->username);
    }
}
