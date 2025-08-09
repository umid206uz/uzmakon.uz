<?php

namespace admin\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use common\models\Product;

/**
 * This is the model class for table "oqim".
 *
 * @property int $id
 * @property int $product_id
 * @property int $user_id
 * @property string $title
 * @property string $key
 * @property int $link
 * @property int $status
 */
class Stream extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'oqim';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required', 'message' => Yii::t("app", "Please! Enter a stream name.") ],
            ['link', 'required', 'message' => Yii::t("app", "Please! Select a post link type.")],
            [['product_id', 'user_id', 'link', 'status'], 'integer'],
            [['title', 'key'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */

    const THROUGH_THE_BOT = 1;
    const THROUGH_THE_SITE = 2;
    const THROUGH_THE_SITE_AND_THE_BOT = 3;

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'product_id' => Yii::t('app', 'Product ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'title' => Yii::t('app', 'Stream name'),
            'link' => Yii::t('app', 'Post link type'),
            'key' => Yii::t('app', 'Key'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    public function beforeValidate(): bool
    {
        $this->user_id = Yii::$app->user->id;
        $this->key = $this->generateRandomKey();
        return parent::beforeValidate();
    }
    
    public function getProduct(): ActiveQuery
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function generateRandomKey(): string
    {
        do {
            $key = Yii::$app->security->generateRandomString(8);
        } while (str_contains($key, '-') || str_contains($key, '_'));

        return $key;
    }

    public function CreateClick(){

        $check = Click::findOne(['user_ip' => Yii::$app->request->userIP, 'oqim_id' => $this->id]);

        if ($check === null){
            $click = new Click();
            $click->oqim_id = $this->id;
            $click->user_id = $this->user->id;
            $click->user_ip = Yii::$app->request->userIP;
            $click->date = time();
            $click->save(false);
        }else{
            $check->date = time();
            $check->save(false);
        }


    }
}
