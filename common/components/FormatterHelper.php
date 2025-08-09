<?php

namespace common\components;

use common\models\AdditionalProduct;
use common\models\User;
use Yii;
use yii\helpers\ArrayHelper;
use yii\i18n\Formatter;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;

class FormatterHelper extends Formatter {

    public function QrCodeGenerate($text): string
    {
        $result = Builder::create()
            ->writer(new PngWriter())
            ->writerOptions([])
            ->data($text)
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
            ->size(300)
            ->margin(10)
            ->roundBlockSizeMode(new RoundBlockSizeModeMargin())
            ->labelText(Yii::$app->params['og_site_name']['content'])
            ->labelFont(new NotoSans(20))
            ->labelAlignment(new LabelAlignmentCenter())
            ->build();
        $data = base64_encode($result->getString());
        header('Content-Type: image:png');
        return $data;
    }

    public function asPhone($value) {
        return preg_replace("/^(\d{2})(\d{3})(\d{2})(\d{2})$/", "($1) $2-$3-$4", $value);
    }

    public function getEventListForScan(): array
    {
        return [
            4 => 'Yangi',
            2 => 'Qaytarildi',
            3 => 'Yetkazildi',
            5 => 'Qayta aloqa'
        ];
    }

    public function currentUser(){
        return User::findOne(Yii::$app->user->id);
    }

    public function cleanPhone($value): string
    {
        return strtr($value, [
            '+998' => '',
            '-' => '',
            '(' => '',
            ')' => '',
            ' ' => '',
            '_' => '',
        ]);
    }

    function removePrefixIfValid($input) {
        if (preg_match('/^\d{12}$/', $input)) {
            if (substr($input, 0, 3) === '998') {
                return substr($input, 3);
            }
        }
        return $input;
    }

    public function asPhoneOperator($value, $order, $operator_id): string
    {
        return ($order->operator_id && $order->operator_id == $operator_id) ? preg_replace("/^(\d{2})(\d{3})(\d{2})(\d{2})$/", "($1) $2-$3-$4", $value) : '(**) ***-**-**';
    }

    public function getPrice($value){
        return number_format((float) $value, 0 , '.', ' ') . ' ' . Yii::t("app", "sum");
    }

    public function getDryPrice($value){
        return number_format((float) $value, 0 , '.', ' ');
    }

    public function getDate($date){
        return ($date) ? date( 'd.m.Y H:i:s', $date) : null;
    }

    public function getDateWithoutTime($date){
        return ($date) ? date( 'd.m.Y', $date) : null;
    }

    public function getCourier(){
        return ArrayHelper::map(User::find()->joinWith('assignment')->where(['auth_assignment.item_name' => 'courier'])->all(), 'id', function ($model){
            return $model->fullName;
        });
    }

    public function getOperator(){
        return ArrayHelper::map(User::find()->joinWith('assignment')->where(['auth_assignment.item_name' => 'operator'])->all(), 'id', function ($model){
            return $model->fullName;
        });
    }

    public function getAdminList(){
        return ArrayHelper::map(User::find()->all(), 'id', function ($model){
            return $model->fullName;
        });
    }

    public function additionalProducts($order): string
    {
        $products = AdditionalProduct::find()->where(['order_id' => $order->id])->with('product')->select(['product_id', 'count'])->all();

        $result = array_map(function($product) {
            return "{$product->product->title}X{$product->count}";
        }, $products);

        return implode(', ', $result);
    }

    public function additionalProductsPrice($order): string
    {
        $result = AdditionalProduct::find()->where(['order_id' => $order->id])->sum('total_price');

        return (int) $result;
    }
    
    public function getSelectStatusForPayment(): array
    {
        return [
            '0' => Yii::t("app","Waiting"),
            '1' => Yii::t("app","Paid"),
        ];
    }

    public function getRegions(): array
    {
        return [
            'Not Set' => 'Not Set',
            'Toshkent shaxri' => 'Toshkent shaxri',
            'Toshkent viloyati' => 'Toshkent viloyati',
            'Buxoro' => 'Buxoro',
            'Navoiy' => 'Navoiy',
            'Samarqand' => 'Samarqand',
            'Jizzax' => 'Jizzax',
            'Andijon' => 'Andijon',
            'Farg`ona' => 'Farg`ona',
            'Namangan' => 'Namangan',
            'Sirdaryo' => 'Sirdaryo',
            'Qoraqalpog`iston' => 'Qoraqalpog`iston',
            'Xorazm' => 'Xorazm',
            'Qashqadaryo' => 'Qashqadaryo',
            'Surxondaryo' => 'Surxondaryo',
        ];
    }

    public function getRegionsForClient(): array
    {
        return [
            'Toshkent shaxri' => 'Toshkent shaxri',
            'Toshkent viloyati' => 'Toshkent viloyati',
            'Buxoro' => 'Buxoro',
            'Navoiy' => 'Navoiy',
            'Samarqand' => 'Samarqand',
            'Jizzax' => 'Jizzax',
            'Andijon' => 'Andijon',
            'Farg`ona' => 'Farg`ona',
            'Namangan' => 'Namangan',
            'Sirdaryo' => 'Sirdaryo',
            'Qoraqalpog`iston' => 'Qoraqalpog`iston',
            'Xorazm' => 'Xorazm',
            'Qashqadaryo' => 'Qashqadaryo',
            'Surxondaryo' => 'Surxondaryo',
        ];
    }
}