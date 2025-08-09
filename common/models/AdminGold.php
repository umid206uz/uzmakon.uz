<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "admin_gold".
 *
 * @property int $id
 * @property int $admin_id
 * @property int $order_id_one
 * @property int|null $order_id_two
 * @property int|null $order_id_three
 * @property string $order_id_one_date
 * @property string|null $order_id_two_date
 * @property string|null $order_id_three_date
 * @property int $order_count
 * @property int $status
 *
 * @property User $admin
 */
class AdminGold extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'admin_gold';
    }

    /**
     * {@inheritdoc}
     */
    public $count;
    public function rules()
    {
        return [
            [['admin_id', 'order_id_one', 'order_id_one_date', 'order_count'], 'required'],
            [['admin_id', 'order_id_one', 'order_id_two', 'order_id_three', 'order_count', 'status'], 'integer'],
            [['order_id_one_date', 'order_id_two_date', 'order_id_three_date'], 'string', 'max' => 255],
            [['admin_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['admin_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'admin_id' => Yii::t('app', 'Admin ID'),
            'order_id_one' => Yii::t('app', 'Order Id One'),
            'order_id_two' => Yii::t('app', 'Order Id Two'),
            'order_id_three' => Yii::t('app', 'Order Id Three'),
            'order_id_one_date' => Yii::t('app', 'Order Id One Date'),
            'order_id_two_date' => Yii::t('app', 'Order Id Two Date'),
            'order_id_three_date' => Yii::t('app', 'Order Id Three Date'),
            'order_count' => Yii::t('app', 'Order Count'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * Gets query for [[Admin]].
     *
     * @param $order
     * @return \yii\db\ActiveQuery
     */

    public function InsertNew($order){

        $adminCoin = self::find()->where(['admin_id'  => $order->user_id])->andWhere(['or', ['order_id_two' => null], ['order_id_three' => null]])->one();
        $adminCoinCheck = self::find()->where(['order_id_one' => $order->id])->orWhere(['order_id_two' => $order->id])->orWhere(['order_id_three' => $order->id])->one();

        if (empty($adminCoinCheck)){
            if ($adminCoin === null){
                $adminCoin = new self();
                $adminCoin->admin_id = $order->user_id;
                $adminCoin->order_id_one = $order->id;
                $adminCoin->order_id_one_date = time();
                $adminCoin->order_count = 1;
                $adminCoin->save(false);
            }
            else{
                if ($adminCoin->order_id_two == null){
                    $adminCoin->order_id_two = $order->id;
                    $adminCoin->order_id_two_date = time();
                    $adminCoin->order_count = 2;
                    $adminCoin->save(false);
                }else{
                    $adminCoin->order_id_three = $order->id;
                    $adminCoin->order_id_three_date = time();
                    $adminCoin->order_count = 3;
                    $adminCoin->save(false);
                }
            }
        }
    }

    public function getAdmin()
    {
        return $this->hasOne(User::className(), ['id' => 'admin_id']);
    }
}
