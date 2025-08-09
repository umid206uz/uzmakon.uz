<?php

namespace admin\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "admin_charity".
 *
 * @property int $id
 * @property int $order_id
 * @property int $admin_id
 * @property int $amount
 * @property int $status
 * @property string $created_date
 * @property string|null $payed_date
 */
class AdminCharity extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'admin_charity';
    }

    /**
     * {@inheritdoc}
     */

    const STATUS_PAID = 1;
    const STATUS_NOT_PAID = 0;

    public function rules()
    {
        return [
            [['order_id', 'admin_id', 'amount', 'status', 'created_date'], 'required'],
            [['order_id', 'admin_id', 'amount', 'status'], 'integer'],
            [['created_date', 'payed_date'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */

    public function getAdmin(): ActiveQuery
    {
        return $this->hasOne(User::className(), ['id' => 'admin_id']);
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'order_id' => Yii::t('app', 'Order ID'),
            'admin_id' => Yii::t('app', 'Admin ID'),
            'amount' => Yii::t('app', 'Amount'),
            'status' => Yii::t('app', 'Status'),
            'created_date' => Yii::t('app', 'Created Date'),
            'payed_date' => Yii::t('app', 'Payed Date'),
        ];
    }
}
