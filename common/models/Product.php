<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property int $category_id
 * @property int $in_stock
 * @property int $charity
 * @property string $title
 * @property string $title_ru
 * @property string $title_en
 * @property string $meta_title
 * @property string $meta_title_ru
 * @property string $meta_title_en
 * @property string $meta_description
 * @property string $meta_description_ru
 * @property string $meta_description_en
 * @property string $url
 * @property string $url_ru
 * @property string $url_en
 * @property string $price
 * @property string $pay
 * @property string $created_date
 * @property string $sale
 * @property string $description
 * @property string $description_ru
 * @property string $description_en
 * @property string $filename
 * @property string $text_telegram_bot
 *
 * @property Category $category
 */
class Product extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public $asd;
    public $subcat;
    public $tag;
    public $picture;
    public function rules()
    {
        return [
            [['category_id', 'brand_id', 'title', 'title_ru', 'title_en', 'price', 'description', 'created_date', 'description_ru', 'description_en', 'meta_description', 'meta_description_ru', 'meta_description_en', 'meta_title', 'meta_title_ru', 'meta_title_en', 'url', 'url_ru', 'url_en', 'text_telegram_bot', 'pay', 'charity', 'sale'], 'required'],
            [['category_id', 'brand_id', 'asd', 'status', 'subcat', 'sale', 'created_date', 'price', 'user_id', 'pay', 'in_stock', 'charity'], 'integer'],
            [['description', 'description_ru', 'description_en', 'meta_description', 'meta_description_ru', 'meta_description_en', 'text_telegram_bot'], 'string'],
            [['tag'], 'safe'],
            [['title', 'title_ru', 'title_en', 'meta_title', 'meta_title_ru', 'meta_title_en', 'url', 'url_ru', 'url_en', 'filename'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            ['picture', 'file', 'extensions' => ['mp4'], 'skipOnEmpty' => true],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => Yii::t("app", "Category"),
            'brand_id' => Yii::t("app", "Brand"),
            'title' => Yii::t("app", "Name (in Uzbek)"),
            'title_ru' => Yii::t("app", "Name (in Russian)"),
            'title_en' => Yii::t("app", "Name (in English)"),
            'description' => Yii::t("app", "Description (in Uzbek)"),
            'description_ru' => Yii::t("app", "Description (in Russian)"),
            'description_en' => Yii::t("app", "Description (in English)"),
            'url' => Yii::t("app", "Url (in Uzbek)"),
            'url_ru' => Yii::t("app", "Url (in Russian)"),
            'url_en' => Yii::t("app", "Url (in English)"),
            'meta_description' => Yii::t("app", "Meta Description (in Uzbek)"),
            'meta_description_ru' => Yii::t("app", "Meta Description (in Russian)"),
            'meta_description_en' => Yii::t("app", "Meta Description (in English)"),
            'meta_title' => Yii::t("app", "Meta Title (in Uzbek)"),
            'meta_title_ru' => Yii::t("app", "Meta Title (in Russian)"),
            'meta_title_en' => Yii::t("app", "Meta Title (in English)"),
            'price' => Yii::t("app", "Price"),
            'tag' => 'Tags',
            'charity' => Yii::t("app", "Charity"),
            'sale' => Yii::t("app", "Sale"),
            'pay' => Yii::t("app", "Bonus for admin"),
            'in_stock' => Yii::t("app", "In stock"),
            'status' => Yii::t("app", "Status"),
            'text_telegram_bot' => Yii::t("app", "Text for Telegram bot"),
            'created_date' => Yii::t("app", "Created Date"),
	        'user_id' => Yii::t("app", "Posted by"),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    public function getTitleTranslate()
    {
        if(\Yii::$app->language == 'ru'){
            return $this->title_ru;
        }
        if(\Yii::$app->language == 'uz'){
            return $this->title;
        }
        if(\Yii::$app->language == 'en'){
            return $this->title_en;
        }
        
    }

    public function Deletes(){
        $this->status = 0;
        if ($this->save()){
            return true;
        }else{
            return false;
        }
    }

    public function getUrl1()
    {
        if(\Yii::$app->language == 'ru'){
            return $this->url_ru;
        }
        if(\Yii::$app->language == 'uz'){
            return $this->url;
        }
        if(\Yii::$app->language == 'en'){
            return $this->url_en;
        }
        
    }

    public function getMetaTitleTranslate()
    {
        if(\Yii::$app->language == 'ru'){
            return $this->meta_title_ru;
        }
        if(\Yii::$app->language == 'uz'){
            return $this->meta_title;
        }
        if(\Yii::$app->language == 'en'){
            return $this->meta_title_en;
        }
        
    }

    public function getMetaDescriptionTranslate()
    {
        if(\Yii::$app->language == 'ru'){
            return $this->meta_description_ru;
        }
        if(\Yii::$app->language == 'uz'){
            return $this->meta_description;
        }
        if(\Yii::$app->language == 'en'){
            return $this->meta_description_en;
        }
        
    }

    public function getDescriptionTranslate()
    {
        if(\Yii::$app->language == 'ru'){
            return $this->description_ru;
        }
        if(\Yii::$app->language == 'uz'){
            return $this->description;
        }
        if(\Yii::$app->language == 'en'){
            return $this->description_en;
        }
        
    }
    
    public function getShortDescription()
    {
        if(\Yii::$app->language == 'uz')
        { 
            $string = $this->description;
        };
        if(\Yii::$app->language == 'en')
        { 
            $string = $this->description_en;
        };
        if(\Yii::$app->language == 'ru')
        { 
            $string = $this->description_ru;
        };
        $string = strip_tags($string);
        $string = substr($string, 0, 2000);
        $string = rtrim($string, "!,.-");
        $string = substr($string, 0, strrpos($string, ' '));
        return $string."… ";
        
    }

    public function getCategory(){
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public function getDelivery(){
        return $this->hasOne(CountryDeliveryPrice::className(), ['product_id' => 'id']);
    }

    public function getBrand(){
        return $this->hasOne(Brand::className(), ['id' => 'brand_id']);
    }

    public function getPosted(){
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
    public function getAtrpro(){
        return $this->hasMany(Atrpro::className(), ['product_id' => 'id']);
    }

    public function getTagsposts(){
        return $this->hasMany(TagsPosts::className(), ['post_id' => 'id']);
    }

    public function getCatpros(){
        return $this->hasMany(Catpro::className(), ['product_id' => 'id']);
    }

    public function getTags(){
        return $this->hasMany(TagsPosts::className(), ['post_id' => 'id']);
    }

    public function getPhotos(){
        return $this->hasMany(Photos::className(), ['product_id' => 'id']);
    }

    public function getLatest(){
        return Product::find()->where(['category_id' => $this->category_id])->limit(5)->orderBy(['id' => SORT_DESC])->all();
    }

    public function getNumber()
    {
        if ($this->sale == null){
            return number_format($this->price);
        }else{
            return number_format($this->sale);
        }
    }

    public function getNumber123($order)
    {
        if ($this->sale == null){
            return number_format($this->price*$order->count);
        }else{
            return number_format($this->sale*$order->count);
        }
    }

    public function getPhoto(){
        return $this->hasOne(Photos::className(), ['product_id' => 'id'])->andWhere(['status' => 1]);
    }

    public function getRandom(){
        return $this->hasOne(Photos::className(), ['product_id' => 'id'])->orderBy(['rand()' => SORT_DESC]);
    }

    public function getArrayProducts()
    {
        $products = Product::find()->asArray()->all();
        $typewriter_products = [];
        foreach ($products as $product)
        {
            if (Yii::$app->language == 'uz')
            {
                $typewriter_products[] = $product["title"];
            }
            if (Yii::$app->language == 'ru')
            {
                $typewriter_products[] = $product["title_ru"];
            }
            if (Yii::$app->language == 'en')
            {
                $typewriter_products[] = $product["title_en"];
            }
        }

        return json_encode($typewriter_products);

    }
}
