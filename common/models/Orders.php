<?php

namespace common\models;

use DateTime;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "orders".
 *
 * @property int $id
 * @property int $oqim_id
 * @property int $status
 * @property int $delete
 * @property int $competition
 * @property int $operator_id
 * @property int $user_id
 * @property int $region_id
 * @property int $district_id
 * @property int $count
 * @property int $qr_code
 * @property int $control_id
 * @property int $is_then
 * @property int $is_hold
 * @property int|null $product_id
 * @property int|null $courier_id
 * @property int|null $returned_id
 * @property string $take_time
 * @property string $addres
 * @property string $full_name
 * @property string $phone
 * @property string $comment
 * @property string $price;
 * @property string $updated_date
 * @property string $delivery_time
 * @property string|null $text
 * @property int|null $additional_phone
 */
class Orders extends ActiveRecord
{
    public $soni;
    public $kuni;
    public $myPageSize;
    public $price;
    private $_user = null;
    private $_product;
    /**
     * {@inheritdoc}
     */

    public static function tableName(): string
    {
        return 'orders';
    }

    /**
     * {@inheritdoc}
     */

    const STATUS_NEW = 0;
    const STATUS_BEING_DELIVERED = 1;
    const STATUS_DELIVERED = 2;
    const STATUS_RETURNED = 3;
    const STATUS_READY_TO_DELIVERY = 4;
    const STATUS_THEN_TAKES = 5;
    const STATUS_HOLD = 6;
    const STATUS_COURIER_RETURNED = 7;
    const STATUS_BLACK_LIST = 8;
    const STATUS_RETURNED_OPERATOR = 9;
    const STATUS_PREPARING = 10;
    const STATUS_FEEDBACK = 11;

    public function rules()
    {
        return [
            [
                [
                    'product_id','control_id', 'status', 'user_id', 'oqim_id',
                    'delete', 'operator_id', 'count', 'courier_id', 'text',
                    'updated_date', 'district_id', 'region_id', 'qr_code',
                    'take_time', 'is_then', 'is_hold', 'returned_id'
                ], 'integer'
            ],
            [['addres', 'full_name', 'phone', 'comment', 'delivery_time'], 'string', 'max' => 255],
            [['myPageSize', 'price', 'competition', 'additional_phone'],'safe'],
            [['full_name'], 'required', 'message' => Yii::t("app","Please enter your first and last name!")],
            [['phone'], 'required', 'message' => Yii::t("app","Please enter your phone number!")],
            [['competition'],'required', 'message' => Yii::t("app","Please enter the shipping fee!"), 'when' => function($model){
                return ($model->control_id == 1) ? true : false;
            }, 'whenClient' => "function (attribute, value) {
                return $('#orders-control_id').val() == 1;
            }"],
            [['region_id'],'required', 'message' => Yii::t("app","Please select a region!"), 'on' => 'create-order'],
            [['district_id'],'required', 'message' => Yii::t("app","Please select a district!"), 'on' => 'create-order'],
            [['product_id'],'required', 'message' => Yii::t("app","Please enter the shipping fee!"), 'on' => 'create-order'],
            [['count'],'required', 'message' => Yii::t("app","Please select a count!"), 'on' => 'create-order'],
            [['addres'],'required', 'message' => Yii::t("app","Please enter more address!"), 'on' => 'create-order'],
            [['comment'],'required', 'message' => Yii::t("app","Please enter more information!"), 'on' => 'create-order'],
            ['phone','findPasswords'],
            ['phone','checkBlackList'],
            ['additional_phone','checkAdditionalPhone']
        ];
    }

    /**
     * {@inheritdoc}
     */

    public function findPasswords($attribute, $params){
        if(strlen(Yii::$app->formatter->cleanPhone($this->phone)) < 9) {
            $this->addError($attribute, Yii::t("app",'Please enter the correct phone number!'));
        }
    }

    public function checkAdditionalPhone($attribute, $params){
        if(strlen(Yii::$app->formatter->cleanPhone($this->additional_phone)) < 9) {
            $this->addError($attribute, Yii::t("app",'Please enter the correct phone number!'));
        }
    }

    public function checkBlackList($attribute, $params){
        $clean_phone = Yii::$app->formatter->cleanPhone($this->phone);
        if(BlackList::find()->where(['phone_number' => $clean_phone])->exists()) {
            $this->addError($attribute, Yii::t("app",'You are blacklisted!'));
        }
    }

    public function getUserStatic()
    {
        if ($this->_user === null) {
            $this->_user = $this->user;
        }
        return $this->_user;
    }

    public function getProductStatic()
    {
        if ($this->_product === null) {
            $this->_product = $this->product;
        }
        return $this->_product;
    }

    public function beforeValidate(): bool
    {
        $this->phone = Yii::$app->formatter->cleanPhone($this->phone);
        $this->additional_phone = Yii::$app->formatter->cleanPhone($this->additional_phone);
        $this->phone = Yii::$app->formatter->removePrefixIfValid($this->phone);
        $this->additional_phone = Yii::$app->formatter->removePrefixIfValid($this->additional_phone);
        if ($this->scenario === 'create-order') {
            $this->operator_id = Yii::$app->user->id;
            $this->status = self::STATUS_READY_TO_DELIVERY;
        }

        return parent::beforeValidate();
    }

    public function beforeSave($insert, $attr = NULL): bool
    {
        $_user = $this->getUserStatic();
        $_product = $this->getProductStatic();
        $this->phone = Yii::$app->formatter->cleanPhone($this->phone);
        $this->additional_phone = Yii::$app->formatter->cleanPhone($this->additional_phone);
        $this->isNewRecord ? $this->text = time() : $this->updated_date = time();

        if ($this->status == self::STATUS_DELIVERED)
        {
            if ($_product->in_stock > 0) {
                $_product->in_stock -= 1;
                $_product->save(false);
            }

            if ($this->returned_id){
                $returned = OrdersReturn::findOne([$this->returned_id]);
                if ($returned){
                    $returned->status = OrdersReturn::STATUS_DELIVERED;
                    $returned->save();
                }
            }

            if ($_product->status == 1) {

                if ($_product->charity == 0) {
                    (new AdminGold())->InsertNew($this);
                    (new AdminOrders())->InsertNew($this);
                }

                if($_user->status_delivered == 1) {
                    $this->SendStatusTelegram(Yii::t("app","order delivered"));
                }

                if ($_product->charity == 1) {
                    (new AdminCharity())->InsertNew($this);
                }
            }

            if ($this->operator_id !== null) {
                (new OperatorOrders())->InsertNew($this);
            }
        }

        if ($this->status == self::STATUS_RETURNED){
            (new OrdersReturn())->insertOrder($this);
            if ($this->returned_id){
                $returned = OrdersReturn::findOne([$this->returned_id]);
                if ($returned){
                    $returned->status = OrdersReturn::STATUS_RETURNED;
                    $returned->save();
                }
            }
            if ($this->oldAttributes['status'] == self::STATUS_DELIVERED){
                $model = AdminOrders::findOne(['order_id' => $this->id]);
                if ($model !== null && $model->status == AdminOrders::STATUS_NOT_PAID && $model->payed_date == null){
                    $model->delete();
                }else{
                    (new AdminOrders())->InsertDebt($this);
                }

                $model = OperatorOrders::findOne(['order_id' => $this->id]);
                if ($model !== null && $model->status == OperatorOrders::STATUS_NOT_PAID && $model->payed_date == null){
                    $model->delete();
                }else{
                    (new OperatorOrders())->InsertDebt($this);
                }
            }
        }

        if ($this->status == self::STATUS_READY_TO_DELIVERY && $_user->status_ready_to_delivery == 1){
            $this->SendStatusTelegram("bilan buyurtma qabul qilindi.");
        }

        if (!$this->isNewRecord && $this->oldAttributes['status'] != $this->status){
            (new OrderLog())->insertNewOrderLog($this);
        }

        if ($this->status == self::STATUS_RETURNED || $this->status == self::STATUS_RETURNED_OPERATOR || $this->status == self::STATUS_COURIER_RETURNED){
            if($_user->status_returned == 1){
                $this->SendStatusTelegram("buyurtma qaytarildi.");
            }
        }

        if($this->status == self::STATUS_THEN_TAKES && $_user->status_then_takes == 1){
            $this->SendStatusTelegram("buyurtma keyin olinadi.");
        }

        if($this->status == self::STATUS_HOLD && $_user->status_hold == 1){
            $this->SendStatusTelegram("buyurtma holdga tushdi.");
        }

        if($this->status == self::STATUS_PREPARING){
            if ($this->returned_id){
                $returned = OrdersReturn::findOne([$this->returned_id]);
                if ($returned){
                    $returned->status = OrdersReturn::STATUS_PREPARING;
                    $returned->save();
                }
            }
            if ($_user->status_preparing == 1){
                $this->SendStatusTelegram("buyurtma Tayyorlanmoqda.");
            }
        }

        if ($this->status == self::STATUS_BLACK_LIST){
            if (!BlackList::find()->where(['phone_number' => $this->phone])->exists()) {
                (new BlackList([
                    'phone_number' => $this->phone,
                    'created_date' => time(),
                ]))->save(false);
            }

            if($_user->status_black_list == 1){
                $this->SendStatusTelegram("buyurtma qora ro'yhatga tushdi.");
            }
        }

        if ($this->status == self::STATUS_BEING_DELIVERED) {
            if ($this->returned_id){
                $returned = OrdersReturn::findOne([$this->returned_id]);
                if ($returned){
                    $returned->status = OrdersReturn::STATUS_BEING_DELIVERED;
                    $returned->save();
                }
            }
            $this->delivery_time = time();
            $this->qr_code = $this->qr_code ?? $this->id . time();
            if ($_user->status_being_delivered == 1){
                $this->SendStatusTelegram("buyurtma yo'lga chiqdi.");
            }
        }

        return parent::beforeSave($insert, $attr = NULL);
    }

    public function insertFromOperatorReturned($order_from_operator_returned): int
    {
        $model = new self();
        $model->product_id = $order_from_operator_returned->product_id;
        $model->operator_id = $order_from_operator_returned->operator_id;
        $model->full_name = $order_from_operator_returned->customer_name;
        $model->phone = $order_from_operator_returned->customer_phone;
        $model->user_id = 1;
        $model->region_id = $order_from_operator_returned->region_id;
        $model->district_id = $order_from_operator_returned->district_id;
        $model->addres = $order_from_operator_returned->address;
        $model->count = $order_from_operator_returned->count;
        $model->competition = $order_from_operator_returned->delivery_type;
        $model->comment = $order_from_operator_returned->comment;
        $model->status = $order_from_operator_returned->status;
        $model->returned_id = $order_from_operator_returned->id;
        $model->save();

        return $model->id;
    }

    public function insertNew($product, $stream = null): bool
    {
        $this->product_id = $product->id;

        if ($stream !== null) {
            $this->oqim_id = $stream->id;
            $this->user_id = $stream->user->id;
        }

        if ($this->save(false)) {
            $this->sendTelegram();
            return true;
        }

        return false;
    }

    public function getSelectUser(): array
    {
        return ArrayHelper::map(User::find()->all(), 'id', function ($model){
            return $model->fullName;
        });
    }

    public function getSelectOperator(): array
    {
        return ArrayHelper::map(User::find()->joinWith('assignment')->where(['auth_assignment.item_name' => 'operator'])->all(), 'id', 'username');
    }

    public function getOqim(): ActiveQuery
    {
        return $this->hasOne(Oqim::className(), ['id' => 'oqim_id']);
    }

    public function getProduct(): ActiveQuery
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    public function getProducts(): ActiveQuery
    {
        return $this->hasMany(Product::className(), ['id' => 'product_id']);
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getOperator(): ActiveQuery
    {
        return $this->hasOne(User::className(), ['id' => 'operator_id']);
    }

    public function getHistory(): ActiveQuery
    {
        return $this->hasMany(OrderLog::className(), ['order_id' => 'id']);
    }

    public function getRegion(): ActiveQuery
    {
        return $this->hasOne(Regions::className(), ['code' => 'region_id']);
    }

    public function getDistrict(): ActiveQuery
    {
        return $this->hasOne(Regions::className(), ['code' => 'district_id']);
    }

    public function getLastMovedDate(): ActiveQuery
    {
        return $this->hasOne(OrderLog::className(), ['order_id' => 'id'])->andWhere(['new_status' => $this->status])->orderBy(['id' => SORT_DESC]);
    }

    public function SendTelegram()
    {
        $text = '';
        $text .= Yii::$app->params['og_site_name']['content'] . " ".date("d.m.Y H:i:s")."\n";
        $text .= "🖊 ФИО: ".$this->full_name."\n";
        $text .= "☎ Телефон: ".$this->phone."\n";
        $text .= "💳 Товар: ".$this->getProductStatic()->title."\n";
        $text .= "💵 Цена: ".Yii::$app->formatter->getPrice($this->getProductStatic()->sale);

        return Yii::$app->bot->sendOrdersBot($text);
    }

    public function SendStatusTelegram($body)
    {
        if ($this->getUserStatic()->step == 3){

            $text = '';
            $text .= Yii::$app->params['og_site_name']['content'] . " ".date("d.m.Y H:i:s")."\n";
            $text .= "🆔 ID - " . $this->id . " " . $body;

            Yii::$app->bot->sendAdminBot($text, $this->getUserStatic()->user_chat_id);
        }
    }

    public function getDeliveryPrice(): int
    {
        return $this->control_id == 1 ? $this->competition : 0;
    }

    public function time_elapsed_string($datetime, $full = false): string
    {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'yil',
            'm' => 'oy',
            'w' => 'hafta',
            'd' => 'kun',
            'h' => 'soat',
            'i' => 'minut',
            's' => 'sekund',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? ' ' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' avval' : 'hozirgna';
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
