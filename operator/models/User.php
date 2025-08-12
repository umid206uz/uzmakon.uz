<?php
namespace operator\models;

use common\models\AuthAssignment;
use common\models\Setting;
use phpDocumentor\Reflection\Types\This;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use kartik\password\StrengthValidator;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $verification_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $card
 * @property string $occupation
 * @property string $url
 * @property string $tell
 * @property string $about
 * @property string $oldpass
 * @property string $newpass
 * @property string $repeatnewpass
 * @property string $filename
 * @property string $picture
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;
    public $oldpass;
    public $newpass;
    public $repeatnewpass;
    public $picture;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first_name' , 'last_name', 'tell', 'occupation', 'url', 'card', 'filename'], 'string', 'max' => 255],
            ['first_name', 'required', 'message' => Yii::t("app", "Please enter your name!"), 'when' => function($model){
                return ( Yii::$app->controller->action->id == 'account' ) ? true : false;
            }],
            ['last_name', 'required', 'message' => Yii::t("app", "Please enter your last name!"), 'when' => function($model){
                return ( Yii::$app->controller->action->id == 'account' ) ? true : false;
            }],
            ['tell', 'required', 'message' => Yii::t("app", "Please enter your phone number!"), 'when' => function($model){
                return ( Yii::$app->controller->action->id == 'account' ) ? true : false;
            }],
            ['card', 'required', 'message' => Yii::t("app", "Please enter your card!"), 'when' => function($model){
                return ( Yii::$app->controller->action->id == 'account' ) ? true : false;
            }],
            ['about', 'string', 'max' => 500],
            [['newpass'],'required', 'message' => Yii::t("app", "Please enter a new password or leave the old password blank!"), 'when' => function($model){
                return ($model->oldpass == '') ? false : true;
            }, 'whenClient' => "function (attribute, value) {
                return $('#user-oldpass').val() != '';
            }"],
            [['repeatnewpass'],'required', 'message' => Yii::t("app", "Please confirm the new password or leave the old password blank!"), 'when' => function($model){
                return ($model->oldpass == '') ? false : true;
            }, 'whenClient' => "function (attribute, value) {
                return $('#user-oldpass').val() != '';
            }"],
            ['oldpass', 'findPasswords'],
            ['tell', 'checkPhone'],
            [['newpass'], StrengthValidator::className(), 'preset'=>'normal', 'userAttribute'=>'username'],
            [['repeatnewpass'], StrengthValidator::className(), 'preset'=>'normal', 'userAttribute'=>'username'],
            ['repeatnewpass','compare', 'message' => Yii::t("app", "No compatibility with new password!") ,'compareAttribute'=>'newpass'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
            ['picture', 'file', 'extensions' => ['jpg', 'jpeg', 'png', 'gif'], 'skipOnEmpty' => true],
        ];
    }

    /**
     * {@inheritdoc}
     */

    public function attributeLabels()
    {
        return [
            'oldpass' => Yii::t("app", "Old Password"),
            'newpass' => Yii::t("app", "New Password"),
            'repeatnewpass' => Yii::t("app", "New Password Confirm"),
            'first_name' => Yii::t("app", "First Name"),
            'last_name' => Yii::t("app", "Last Name"),
            'tell' => Yii::t("app", "Phone number"),
            'card' => Yii::t("app", "Credit Card"),
            'occupation' => Yii::t("app", "Occupation"),
            'about' => Yii::t("app", "Briefly about yourself"),
            'url' => Yii::t("app", "Website Url"),

        ];
    }

    public function findPasswords($attribute, $params){
        $user = User::find()->where([
            'username'=>Yii::$app->user->identity->username
        ])->one();

        $password = $user->password_hash;  //returns current password as stored in the dbase

        if(!Yii::$app->security->validatePassword($this->oldpass, $password))
        {
            $this->addError($attribute, \Yii::t("app",'Old password is incorrect'));
            Yii::$app->getSession()->setFlash('danger', \Yii::t("app",'Old password is incorrect'));
        }

    }

    public function checkPhone($attribute, $params){

        $this->tell = strtr($this->tell, [
            '+998' => '',
            '-' => '',
            '(' => '',
            ')' => '',
            ' ' => ''
        ]);

        $user = self::find()->where([
            'tell' => $this->tell
        ])->one();

        if(!empty($user) && $this->oldAttributes['tell'] != $this->tell)
        {
            $this->addError($attribute, \Yii::t("app",Yii::t("app", "This phone number was used")));
        }

    }

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findByUsername1($username)
    {
        return static::findOne(['tell' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token) {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function getRole(){
        return $this->hasOne(AuthAssignment::className(), ['user_id' => 'id']);
    }

    public function getAvatar(){
        if ($this->filename == '' || !file_exists('uploads/user/' . $this->filename)){
            return 'https://' . Yii::$app->params['og_site_name']['content'] . '/backend/web/uploads/' . Setting::findOne(1)->open_graph_photo;
        }else{
            return '/uploads/user/' . $this->filename;
        }
    }

    public function getFullName()
    {
        if ($this->first_name == ''){
            return Yii::t("app", "Full name");
        }else{
            return $this->first_name . ' ' . $this->last_name;
        }
    }
}
