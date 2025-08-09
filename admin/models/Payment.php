<?php

namespace admin\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "payment".
 *
 * @property int $id
 * @property int $user_id
 * @property string $created_date
 * @property string $payed_date
 * @property int $status
 * @property int $amount
 */
class Payment extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'payment';
    }

    /**
     * {@inheritdoc}
     */

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['create-payment'] = $scenarios[self::SCENARIO_DEFAULT];
        return $scenarios;
    }

    const STATUS_EXPECTED = 0;
    const STATUS_PAYED = 1;
    const STATUS_NOT_PAID = 0;
    const STATUS_PAID = 1;

    public function rules()
    {
        return [
            [['status', 'created_date', 'payed_date', 'user_id'], 'integer'],
            [['amount'], 'required', 'message' => Yii::t("app", "Please enter the amount")],
            [['amount'], 'integer', 'message' => Yii::t("app", "Enter the amount in numbers")],
            [['user_id', 'status', 'created_date'], 'safe', 'on' => 'create-payment'],
            ['amount','checkAmount'],
            ['amount','checkPayment'],
            ['amount','checkLimit'],
            ['amount', 'checkCard']
        ];
    }

    public function beforeSave($insert): bool
    {
        if ($this->scenario === 'create-payment') {
            $this->user_id = Yii::$app->user->id;
            $this->status = self::STATUS_NOT_PAID;
            $this->created_date = time();
        }
        return parent::beforeSave($insert);
    }

    public function checkAmount($attribute, $params){

        $balance_difference = AdminOrders::find()
            ->select(['balance_difference' => 'SUM(CASE WHEN debit = :debit_right THEN amount ELSE 0 END) - SUM(CASE WHEN debit = :debit_debt THEN amount ELSE 0 END)',])
            ->where(['admin_id' => Yii::$app->user->id, 'status' => AdminOrders::STATUS_NOT_PAID])
            ->params([':debit_right' => AdminOrders::DEBIT_RIGHT, ':debit_debt' => AdminOrders::DEBIT_DEBT])->scalar();

        if($this->amount > $balance_difference || $this->amount < 0) {
            $this->addError($attribute, Yii::t("app","You don't have enough money in your account. Please keep working!"));
        }
    }

    public function checkPayment($attribute, $params){
        if(self::find()->where(['user_id' => Yii::$app->user->id, 'status' => self::STATUS_EXPECTED])->exists()) {
            $this->addError($attribute, Yii::t("app","You have an outstanding balance. Please wait."));
        }
    }

    public function checkCard($attribute, $params){
        if(!Yii::$app->formatter->currentUser()->card) {
            $this->addError($attribute, Yii::t("app","Please enter your personal plastic card from the Profile menu"));
        }
    }

    public function checkLimit($attribute, $params){
        if($this->amount < 50000) {
            $this->addError($attribute, Yii::t("app",'The minimum withdrawal is 50 000 sum'));
        }
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getStatusForPanel(): string
    {
        if ($this->status == self::STATUS_PAID) {
            return '<span class="badge badge-success">' . Yii::t("app", "Paid") . '</span>';
        }elseif ($this->status == self::STATUS_NOT_PAID) {
            return '<span class="badge badge-danger">' . Yii::t("app", "Waiting") . '</span>';
        }else{
            return (string) $this->status;
        }
    }

    public function attributeLabels(){
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'Admin'),
            'created_date' => Yii::t('app', 'Created Date'),
            'payed_date' => Yii::t('app', 'Payed Date'),
            'status' => Yii::t('app', 'Status'),
            'amount' => Yii::t('app', 'Money amount'),
        ];
    }
}
