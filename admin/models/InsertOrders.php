<?php

namespace admin\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "insert_orders".
 *
 * @property int $id
 * @property int $user_id
 * @property string $filename
 * @property int $inserted
 * @property int $double
 * @property int $error
 * @property int $status
 * @property int $created_date
 * @property int|null $updated_date
 */
class InsertOrders extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'insert_orders';
    }

    public $excel;

    const STATUS_NEW = 0;
    const STATUS_PREPARED = 1;
    const STATUS_READY = 2;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'inserted', 'double', 'error', 'status', 'created_date', 'updated_date'], 'integer'],
            [['filename'], 'string', 'max' => 100],
            [['excel'], 'file', 'extensions' => ['xls', 'xlsx'], 'skipOnEmpty' => true],
        ];
    }

    public function beforeSave($insert): bool
    {
        if ($this->isNewRecord){
            $this->user_id = Yii::$app->user->id;
            $this->status = self::STATUS_NEW;
            $this->created_date = time();
        }
        return parent::beforeSave($insert);
    }

    /**
     * {@inheritdoc}
     */

    public function getStatusStyle(): string
    {
        if ($this->status == self::STATUS_NEW) {
            return '<span class="badge border border-info text-info">' . Yii::t("app","New") . '</span>';
        }elseif ($this->status == self::STATUS_PREPARED) {
            return '<span class="badge border border-warning text-warning">' . Yii::t("app","Preparing") . '</span>';
        }elseif ($this->status == self::STATUS_READY) {
            return '<span class="badge border border-success text-success">' . Yii::t("app","Ready") . '</span>';
        }else{
            return (string) $this->status;
        }
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function adminSendTelegram($data)
    {
        if ($this->user->step == 3){
            Yii::$app->bot->sendAdminBot($data, $this->user->user_chat_id);
        }
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'filename' => Yii::t('app', 'Filename'),
            'inserted' => Yii::t('app', 'Inserted'),
            'double' => Yii::t('app', 'Double'),
            'error' => Yii::t('app', 'Error'),
            'status' => Yii::t('app', 'Status'),
            'created_date' => Yii::t('app', 'Created Date'),
            'updated_date' => Yii::t('app', 'Updated date'),
        ];
    }
}
