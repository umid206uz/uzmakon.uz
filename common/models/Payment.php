<?php

namespace common\models;

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

    const STATUS_EXPECTED = 0;
    const STATUS_PAYED = 1;
    const STATUS_NOT_PAID = 0;
    const STATUS_PAID = 1;

    public function rules()
    {
        return [
            [['user_id', 'created_date'], 'required'],
            [['amount'], 'required', 'message' => Yii::t("app", "Please enter the amount")],
            [['amount'], 'integer', 'message' => Yii::t("app", "Enter the amount in numbers")],
            [['status', 'created_date', 'payed_date', 'user_id'], 'integer']
        ];
    }

    public function AdminSendTelegram(){
        if ($this->user->step == 3){
            $text = '';
            $text .= Yii::$app->params['og_site_name']['content'] . " - pul o'tkazish so'rovi amalga oshirildi.\n";
            $text .= "Summa - " . number_format($this->amount) . " uzs \n";
            $text .= "Karta - ".$this->user->card." \n";

            Yii::$app->bot->sendAdminBot($text, $this->user->user_chat_id);

            return  true;
        }
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getStatusForPayment(): string
    {
        if ($this->status == self::STATUS_PAID) {
            return '<span class="label label-success">'. Yii::t("app", "Paid") .'</span>';
        }elseif($this->status == self::STATUS_NOT_PAID) {
            return '<span class="label label-danger">'. Yii::t("app", "Not paid") .'</span>';
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
