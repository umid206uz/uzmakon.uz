<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "black_list".
 *
 * @property int $id
 * @property string|null $phone_number
 * @property string|null $created_date
 */
class BlackList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'black_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['phone_number', 'created_date'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'phone_number' => Yii::t('app', 'Phone Number'),
            'created_date' => Yii::t('app', 'Created Date'),
        ];
    }
}
