<?php

namespace admin\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "charity_payment".
 *
 * @property int $id
 * @property int $user_id
 * @property int $status
 * @property int $count
 * @property int $amount
 * @property int $created_date
 * @property int|null $payed_date
 */
class CharityPayment extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'charity_payment';
    }

    /**
     * {@inheritdoc}
     */

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['create-charity'] = $scenarios[self::SCENARIO_DEFAULT];
        return $scenarios;
    }

    const STATUS_PAID = 1;
    const STATUS_NOT_PAID = 0;

    public function rules()
    {
        return [
            [['count'], 'required', 'message' => Yii::t("app", "Enter the number of coins!")],
            [['user_id', 'status', 'count', 'amount', 'created_date', 'payed_date'], 'integer'],
            ['count','checkAmount'],
            ['count','checkPayment'],
        ];
    }

    public function beforeValidate()
    {
        if ($this->scenario === 'create-charity') {
            $this->created_date = time();
            $this->user_id = Yii::$app->user->id;
            $this->status = CharityPayment::STATUS_NOT_PAID;
            $this->amount = AdminCharity::find()->where(['admin_id' => Yii::$app->user->id, 'status' => AdminCharity::STATUS_NOT_PAID])->limit($this->count)->sum('amount');
        }
        return parent::beforeValidate();
    }

    public function checkAmount($attribute, $params){

        $count = AdminCharity::find()->where(['admin_id' => Yii::$app->user->id, 'status' => AdminCharity::STATUS_NOT_PAID])->count();

        if($this->count > $count) {
            $this->addError($attribute, Yii::t("app","You don't have enough coins in your account. Please keep up the good work!"));
        }
    }

    public function checkPayment($attribute, $params){

        $expected = self::findAll(['user_id' => Yii::$app->user->id, 'status' => self::STATUS_NOT_PAID]);

        if($expected) {
            $this->addError($attribute, Yii::t("app","You have an outstanding balance. Please wait."));
        }
    }

    public function getUser(){
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getStatusName(){
        if ($this->status == self::STATUS_PAID){
            return '<span class="badge border border-success text-success">' . Yii::t("app", "Paid") . '</span>';
        }elseif ($this->status == self::STATUS_NOT_PAID){
            return '<span class="badge border border-danger text-danger">' . Yii::t("app", "Not paid") . '</span>';
        }else{
            return $this->status;
        }
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'Admin'),
            'status' => Yii::t('app', 'Status'),
            'count' => Yii::t('app', 'Number of coins'),
            'amount' => Yii::t('app', 'Money amount'),
            'created_date' => Yii::t('app', 'Created Date'),
            'payed_date' => Yii::t('app', 'Payed Date'),
        ];
    }
}
