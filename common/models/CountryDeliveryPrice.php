<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "country_delivery_price".
 *
 * @property int $id
 * @property int $product_id
 * @property int $tashkent_city
 * @property int $tashkent_region
 * @property int $bukhara
 * @property int $navoi
 * @property int $samarkand
 * @property int $jizzakh
 * @property int $andijan
 * @property int $fergana
 * @property int $namangan
 * @property int $syrdarya
 * @property int $karakalpakstan
 * @property int $khorezm
 * @property int $kashkadarya
 * @property int $surkhandarya
 */
class CountryDeliveryPrice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'country_delivery_price';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'tashkent_city', 'tashkent_region', 'bukhara', 'navoi', 'samarkand', 'jizzakh', 'andijan', 'fergana', 'namangan', 'syrdarya', 'karakalpakstan', 'khorezm', 'kashkadarya', 'surkhandarya'], 'required'],
            [['product_id', 'tashkent_city', 'tashkent_region', 'bukhara', 'navoi', 'samarkand', 'jizzakh', 'andijan', 'fergana', 'namangan', 'syrdarya', 'karakalpakstan', 'khorezm', 'kashkadarya', 'surkhandarya'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'product_id' => Yii::t('app', 'Product ID'),
            'tashkent_city' => Yii::t('app', 'Tashkent City'),
            'tashkent_region' => Yii::t('app', 'Tashkent Region'),
            'bukhara' => Yii::t('app', 'Bukhara'),
            'navoi' => Yii::t('app', 'Navoi'),
            'samarkand' => Yii::t('app', 'Samarkand'),
            'jizzakh' => Yii::t('app', 'Jizzakh'),
            'andijan' => Yii::t('app', 'Andijan'),
            'fergana' => Yii::t('app', 'Fergana'),
            'namangan' => Yii::t('app', 'Namangan'),
            'syrdarya' => Yii::t('app', 'Syrdarya'),
            'karakalpakstan' => Yii::t('app', 'Karakalpakstan'),
            'khorezm' => Yii::t('app', 'Khorezm'),
            'kashkadarya' => Yii::t('app', 'Kashkadarya'),
            'surkhandarya' => Yii::t('app', 'Surkhandarya'),
        ];
    }
}
