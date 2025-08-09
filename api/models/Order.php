<?php

namespace api\models;

use common\models\Oqim;
use common\models\Product;
use common\models\User;
use Yii;
use yii\db\ActiveRecord;
use common\models\BlackList;

/**
 * This is the model class for table "orders".
 *
 * @property int $api_key
 * @property int $offer_id
 * @property int $oqim_id
 * @property string $phone
 * @property string $name
 * @property string $full_name
 * @property int $user_id
 * @property int $product_id
 * @property string $stream
 */
class Order extends ActiveRecord
{
    public $api_key;
    public $offer_id;
    public $name;
    public $stream;
    private $_user;
    private $_product;
    private $_stream;
    /**
     * {@inheritdoc}
     */

    public static function tableName(): string
    {
        return 'orders';
    }

    public function rules()
    {
        return [
            [
                [
                    'product_id','api_key', 'offer_id', 'user_id', 'oqim_id'
                ], 'integer'
            ],
            [['api_key'], 'required', 'message' => Yii::t("app","Please enter your api_key!")],
            [['offer_id'], 'required', 'message' => Yii::t("app","Please enter your offer_id!")],
            [['name'], 'required', 'message' => Yii::t("app","Please enter your first and last name!")],
            [['stream'], 'required', 'message' => Yii::t("app","Please enter your stream!")],
            [['phone'], 'required', 'message' => Yii::t("app","Please enter your phone number!")],
            ['phone','checkPhoneLength'],
            ['phone','checkBlackList'],
            ['api_key', 'checkApiKey'],
            ['offer_id', 'checkOffer'],
            ['stream', 'checkStream'],
            ['stream', 'checkUserApiKey'],
            ['stream', 'checkOfferApiKey'],
        ];
    }

    /**
     * {@inheritdoc}
     */

    public function beforeValidate(): bool
    {
        $this->full_name = $this->name;
        $this->oqim_id = $this->_stream->id;
        $this->product_id = $this->_product->id;
        $this->user_id = $this->_user->id;
        return parent::beforeValidate();
    }

    public function checkPhoneLength($attribute, $params){
        if(strlen(Yii::$app->formatter->cleanPhone($this->phone)) < 9) {
            $this->addError($attribute, Yii::t("app",'Please enter the correct phone number!'));
        }
    }

    public function checkBlackList($attribute, $params){
        $clean_phone = Yii::$app->formatter->cleanPhone($this->phone);
        if(BlackList::find()->where(['phone_number' => $clean_phone])->exists()) {
            $this->addError($attribute, Yii::t("app",'You are blacklisted!'));
        }
    }

    public function checkApiKey($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user) {
                $this->addError($attribute, Yii::t("app","Your api_key incorrect!"));
            }
        }
    }

    public function checkOffer($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $product = $this->getProduct();
            if (!$product) {
                $this->addError($attribute, Yii::t("app","Your offer_id incorrect!"));
            }
        }
    }

    public function checkStream($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $stream = $this->getStream();
            if (!$stream) {
                $this->addError($attribute, Yii::t("app","Your stream incorrect!"));
            }
        }
    }

    public function checkUserApiKey($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $stream = $this->getStream();
            $user = $this->getUser();
            if ($stream->user_id != $user->id) {
                $this->addError($attribute, Yii::t("app","stream api_key ga mos emas!"));
            }
        }
    }

    public function checkOfferApiKey($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $stream = $this->getStream();
            $product = $this->getProduct();
            if ($stream->product_id != $product->id) {
                $this->addError($attribute, Yii::t("app","stream offer_id ga mos emas!"));
            }
        }
    }

    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByApiKey($this->api_key);
        }

        return $this->_user;
    }

    protected function getProduct()
    {
        if ($this->_product === null) {
            $this->_product = Product::findOne($this->offer_id);
        }

        return $this->_product;
    }

    protected function getStream()
    {
        if ($this->_stream === null) {
            $this->_stream = Oqim::findOne(['key' => $this->stream]);
        }

        return $this->_stream;
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'product_id' => Yii::t("app", "Product Name"),
            'operator_id' => Yii::t("app", "Operator"),
            'control_id' => Yii::t("app", "Delivery type"),
            'district_id' => Yii::t("app", "District"),
            'region_id' => Yii::t("app", "Region"),
            'competition' => Yii::t("app", "Delivery price"),
            'count' => Yii::t("app", "Count"),
            'user_id' => Yii::t("app", "Admin"),
            'status' => Yii::t("app", "Status"),
            'full_name' => Yii::t("app", "Client"),
            'phone' => Yii::t("app", "Customer phone number"),
            'text' => Yii::t("app", "Order date"),
            'delivery_time' => Yii::t("app", "Approved date"),
            'comment' => Yii::t("app", "Additional Information"),
            'additional_phone' => Yii::t("app", "Additional phone number"),
            'addres' => Yii::t("app", "Additional address"),
            'oqim_id' => Yii::t("app", "Stream"),
            'take_time' => Yii::t("app", "Take time"),
            'courier_id' => Yii::t("app", "Courier"),
        ];
    }
}
