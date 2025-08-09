<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "telegram".
 *
 * @property int $id
 * @property string $full_name
 * @property int $user_chat_id
 * @property int|null $status
 */
class Telegram extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'telegram';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['full_name', 'user_chat_id'], 'required'],
            [['user_chat_id', 'status'], 'integer'],
            [['full_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'full_name' => Yii::t('app', 'Full name'),
            'user_chat_id' => Yii::t('app', 'User Chat ID'),
            'status' => Yii::t('app', 'Status'),
        ];
    }
}
