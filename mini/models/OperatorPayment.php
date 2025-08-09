<?php

namespace mini\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use common\models\OperatorOrders;

/**
 * This is the model class for table "operator_payment".
 *
 * @property int $id
 * @property int $operator_id
 * @property int $amount
 * @property int $status
 * @property int $created_date
 * @property int|null $payed_date
 */
class OperatorPayment extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'operator_payment';
    }

    /**
     * {@inheritdoc}
     */

    public function scenarios(): array
    {
        $scenarios = parent::scenarios();
        $scenarios['create-payment'] = $scenarios[self::SCENARIO_DEFAULT];
        return $scenarios;
    }

    const STATUS_PAYED = 1;
    const STATUS_NOT_PAYED = 0;

    public function rules()
    {
        return [
            [['operator_id', 'created_date'], 'required'],
            [['amount'], 'required', 'message' => Yii::t("app", "Please enter the amount")],
            [['amount'], 'integer', 'message' => Yii::t("app", "Enter the amount in numbers")],
            [['operator_id', 'status', 'created_date', 'payed_date'], 'integer'],
            ['amount', 'checkAmount'],
            ['amount','checkPayment'],
            ['operator_id', 'checkCard']
        ];
    }

    public function beforeValidate(): bool
    {
        if ($this->scenario === 'create-payment') {
            $this->operator_id = Yii::$app->user->id;
            $this->status = OperatorPayment::STATUS_NOT_PAYED;
            $this->created_date = time();
        }
        return parent::beforeValidate();
    }

    public function checkAmount($attribute, $params){
        $balance_difference = OperatorOrders::find()
            ->select(['balance_difference' => 'SUM(CASE WHEN debit = :debit_right THEN amount ELSE 0 END) - SUM(CASE WHEN debit = :debit_debt THEN amount ELSE 0 END)',])
            ->where(['operator_id' => Yii::$app->user->id, 'status' => OperatorOrders::STATUS_NOT_PAID])
            ->params([':debit_right' => OperatorOrders::DEBIT_RIGHT, ':debit_debt' => OperatorOrders::DEBIT_DEBT])->scalar();
        if($this->amount > $balance_difference || $this->amount < 0) {
            $this->addError($attribute, Yii::t("app","You don't have enough money in your account, please continue working!"));
        }
    }

    public function checkPayment($attribute, $params){
        if(self::find()->where(['operator_id' => Yii::$app->user->id, 'status' => OperatorPayment::STATUS_NOT_PAYED])->exists()) {
            $this->addError($attribute, Yii::t("app",'You have an outstanding money request, please wait'));
        }
    }

    public function checkCard($attribute, $params){
        if(!Yii::$app->formatter->currentUser()->card) {
            $this->addError($attribute, Yii::t("app","Please enter your personal plastic card from the Profile menu"));
        }
    }

    public function getOperator(): ActiveQuery
    {
        return $this->hasOne(User::className(), ['id' => 'operator_id']);
    }

    public function getStatusForPanel(): string
    {
        if ($this->status == self::STATUS_PAYED) {
            return '<span class="label label-success">' . Yii::t("app", "Paid") . '</span>';
        }elseif($this->status == self::STATUS_NOT_PAYED) {
            return '<span class="label label-warning">' . Yii::t("app", "Waiting") . '</span>';
        }else{
            return '<span class="label label-primary">' . Yii::t("app", "Unknown") . '</span>';
        }
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'operator_id' => Yii::t('app', 'Operator'),
            'amount' => Yii::t('app', 'Money amount'),
            'status' => Yii::t('app', 'Status'),
            'created_date' => Yii::t('app', 'Created Date'),
            'payed_date' => Yii::t('app', 'Payed Date'),
        ];
    }
}
