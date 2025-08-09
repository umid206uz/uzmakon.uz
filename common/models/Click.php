<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "click".
 *
 * @property int $id
 * @property string $date
 * @property int $oqim_id
 * @property int $user_id
 * @property int $user_ip
 */
class Click extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'click';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date'], 'required'],
            [['oqim_id', 'user_id'], 'integer'],
            [['date', 'user_ip'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'date' => Yii::t('app', 'Date'),
        ];
    }
}
