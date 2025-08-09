<?php

namespace common\models;

use Yii;

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
class Oqim extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
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

    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    public function getStream()
    {
        return $this->hasOne(Stream::className(), ['oqim_id' => 'id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function Key()
    {
        $this->key = Yii::$app->security->generateRandomString();
    }
    public function Create($id)
    {
        $this->key = Yii::$app->security->generateRandomString(6);

        while (strpos($this->key,'-') !== false or strpos($this->key,'_') !== false)
        {
            $this->key = Yii::$app->security->generateRandomString(6);
        }

        $this->user_id = Yii::$app->user->id;
        $this->title = $this->title;
        $this->product_id = $id;

        if($this->save(false))
        {
            return true;
        }
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
