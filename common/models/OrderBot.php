<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "order_bot".
 *
 * @property int $id
 * @property int $user_chat_id
 * @property int|null $phone
 * @property string|null $full_name
 * @property int $step
 * @property int $status
 * @property int $admin_id
 * @property int $product_id
 * @property int|null $order_id
 * @property int|null $stream_id
 * @property string|null $time
 */
class OrderBot extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_bot';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_chat_id', 'product_id', 'admin_id'], 'required'],
            [['user_chat_id', 'phone', 'step', 'status', 'order_id', 'product_id', 'admin_id', 'stream_id'], 'integer'],
            [['full_name'], 'string', 'max' => 100],
            [['time'], 'string', 'max' => 25],
        ];
    }

    /**
     * {@inheritdoc}
     */

    public function insertOrder(){
        $model = new Orders();
        $model->full_name = $this->full_name;
        $model->phone = Yii::$app->formatter->removePrefixIfValid($this->phone);
        $model->user_id = $this->admin_id;
        $model->oqim_id = $this->stream_id;
        $model->product_id = $this->product_id;
        $model->save();

        $this->order_id = $model->id;
        $this->status = 1;
        $this->save(false);
        return true;
    }

    public function getKeyboardPhone(){
        return json_encode([
            'resize_keyboard' => true,
            'keyboard' => [
                [
                    ['text' => "📞 Raqamni jo'natish", "request_contact" => true]
                ],
                [
                    ['text' => "⬅️ Ortga"],
                ]
            ]
        ]);
    }

    public function getKeyboardBack(){
        return json_encode([
            'resize_keyboard' => true,
            'keyboard' => [
                [
                    ['text' => "⬅️ Ortga"],
                ]
            ]
        ]);
    }

    public function getKeyboardSuccess(){
        return json_encode([
            'resize_keyboard' => true,
            'keyboard' => [
                [
                    ['text' => "🥳 Raxmat!"],
                ]
            ]
        ]);
    }

    public function getKeyboardError(){
        return json_encode([
            'resize_keyboard' => true,
            'keyboard' => [
                [
                    ['text' => "Bekor qilindi 😞"],
                ]
            ]
        ]);
    }

    public function getKeyboardCancel(){
        return json_encode([
            'resize_keyboard' => true,
            'keyboard' => [
                [
                    ['text' => "❌ Bekor qilish"],
                ]
            ]
        ]);
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_chat_id' => Yii::t('app', 'User Chat ID'),
            'phone' => Yii::t('app', 'Phone'),
            'full_name' => Yii::t('app', 'Full Name'),
            'step' => Yii::t('app', 'Step'),
            'status' => Yii::t('app', 'Status'),
            'order_id' => Yii::t('app', 'Order ID'),
            'time' => Yii::t('app', 'Time'),
        ];
    }
}
