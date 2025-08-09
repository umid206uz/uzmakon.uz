<?php

/* @var $this yii\web\View */
/* @var $searchModel common\models\OrdersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Buyurtmalar';
?>
<style>
    #customers {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    #customers td, #customers th {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #customers tr:nth-child(even){background-color: #f2f2f2;}

    #customers tr:hover {background-color: #ddd;}

    #customers th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #3c8dbc;
        color: white;
    }
</style>
<div class="orders-index container box">
    <?=date("Y-m-d H:i:s")?>
    <br>
    <table id="customers">
        <tr>
            <th>№</th>
            <th>ID</th>
            <th>Mahsulot nomi</th>
            <th>Xaridor</th>
            <th>Viloyat</th>
            <th>Buyurtma sanasi</th>
            <th>Narxi</th>
            <th>Comment</th>
            <th>Qr code</th>
        </tr>
        <?php $k = 1; $c=0; $delivery = 0; foreach ($dataProvider->getModels() as $item):?>
            <tr>
                <td><?=$k?></td>
                <td><?=$item->id?></td>
                <td><?=$item->product->title?>x<?=$item->count?> <?=Yii::$app->formatter->additionalProducts($item)?></td>
                <td><?=$item->full_name?> <br><br> <?=$item->phone?></td>
                <td><?=$item->region->name?> <?=$item->district->name?></td>
                <td><?= date('Y-m-d H:i:s',$item->text)?></td>
                <td><?=Yii::$app->formatter->getPrice($item->count*$item->product->sale + Yii::$app->formatter->additionalProductsPrice($item))?> <br> Dostafka: <?=Yii::$app->formatter->getPrice($item->deliveryPrice)?></td>
                <td><?=$item->comment?></td>
                <td><img width="100" height="100" src="data:image/png;base64,<?=Yii::$app->formatter->QrCodeGenerate('https://kuryer.uzmakon.uz/confirm/' . $item->qr_code)?>"></td>
            </tr>
            <?php $k++; $c = $c + $item->product->sale*$item->count + Yii::$app->formatter->additionalProductsPrice($item); $delivery = $delivery + $item->deliveryPrice; endforeach;?>
        <tr>
            <td>Jami:</td>
            <td>
                Mahsulot summasi: <?=Yii::$app->formatter->getPrice($c)?> <br>
                Yetkazish summasi: <?=Yii::$app->formatter->getPrice($delivery)?> <br>
                Umumiy summa: <?=Yii::$app->formatter->getPrice($c + $delivery)?> <br>
            </td>
        </tr>
    </table>
    <?=date("Y-m-d H:i:s")?>
    <br>
</div>