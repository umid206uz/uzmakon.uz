<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "message".
 *
 * @property int $id
 * @property string $full_name
 * @property string $mail
 * @property string $subject
 * @property string $text
 */
class Message extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'message';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['full_name', 'mail', 'subject'], 'required'],
            [['text'], 'string'],
            [['full_name', 'mail'], 'string', 'max' => 255],
            [['subject'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'full_name' => 'Full Name',
            'mail' => 'Mail',
            'subject' => 'Subject',
            'text' => 'Text',
        ];
    }
}
