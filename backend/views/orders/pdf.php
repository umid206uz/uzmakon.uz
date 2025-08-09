<?php

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $item common\models\Orders */

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
            <th>ID</th>
            <th>Mahsulot nomi</th>
            <th>Xaridor</th>
            <th>Viloyat</th>
            <th>Xaridor raqami</th>
            <th>Buyurtma sanasi</th>
            <th>Status</th>
            <th>Comment</th>
        </tr>
        <?php foreach ($dataProvider->getModels() as $item):?>
            <tr>
                <td><?=$item->id?></td>
                <td><?=$item->product->title?></td>
                <td><?=$item->full_name?></td>
                <td><?=$item->region->name?> <?=$item->district->name?></td>
                <td><?=$item->phone?></td>
                <td><?= date('Y-m-d H:i:s',$item->text)?></td>
                <td><?=$item->statuses?></td>
                <td><?=$item->comment?></td>
            </tr>
        <?php endforeach;?>
    </table>
    <?php if (Yii::$app->controller->action->id == 'pdf-action'):?>
        <?php $c=1; foreach ($dataProvider->getModels() as $item):?>

            <div style="float: left; width: 50%;<?=($c == 1) ? "page-break-before: always" : ""?> <?=($c%8 == 0) ? "page-break-before: always" : ""?>">
                <table style=" border: 1px solid #000">
                    <tr>
                        <th style="padding:3px; border: 1px solid black; font-size: 10px;"><?=Yii::$app->params['og_site_name']['content']?></th>
                        <td style="padding:3px; border: 1px solid black; font-size: 10px"><?=date("Y-m-d H:i:s", $item->text)?></td>
                        <td rowspan="10" style="padding:3px; border: 1px solid black; font-size: 10px">
                            <img width="100" src="<?=Yii::$app->request->hostInfo . '/backend/web/uploads/17457013612290.jpg'?>" alt="">
                            <img width="100" height="100" src="data:image/png;base64,<?=Yii::$app->formatter->QrCodeGenerate('https://kuryer.uzmakon.uz/confirm/' . $item->qr_code)?>">
                        </td>

                    </tr>
                    <tr>
                        <th style="padding:3px; border: 1px solid black; font-size: 10px;">ID: <?=$item->id?></th>
                        <td style="padding:3px; border: 1px solid black; font-size: 10px"><?=date("Y-m-d H:i:s")?></td>
                    </tr>
                    <tr>
                        <td style="padding:3px; border: 1px solid black; font-size: 10px">F.I.O:</td>
                        <td style="padding:3px; border: 1px solid black; font-size: 10px"><?=$item->full_name?></td>
                    </tr>
                    <tr>
                        <td style="padding:3px; border: 1px solid black; font-size: 10px">Manzil:</td>
                        <td style="padding:3px; border: 1px solid black; font-size: 10px"><?=$item->region->name?> <?=$item->district->name?> <?=$item->addres?></td>
                    </tr>
                    <tr>
                        <td style="padding:3px; border: 1px solid black; font-size: 10px">Mahsulot:</td>
                        <td style="padding:3px; border: 1px solid black; font-size: 10px"><?=$item->product->title?></td>
                    </tr>
                    <tr>
                        <td style="padding:3px; border: 1px solid black; font-size: 10px">Izoh:</td>
                        <td style="padding:3px; border: 1px solid black; font-size: 10px"><?=$item->comment?></td>
                    </tr>
                    <tr>
                        <td style="padding:3px; border: 1px solid black; font-size: 10px">Telefon:</td>
                        <td style="padding:3px; border: 1px solid black; font-size: 10px"><?=Yii::$app->formatter->asPhone($item->phone)?> <br> <?=Yii::$app->formatter->asPhone($item->additional_phone)?></td>
                    </tr>
                    <tr>
                        <td style="padding:3px; border: 1px solid black; font-size: 10px">Soni:</td>
                        <td style="padding:3px; border: 1px solid black; font-size: 10px"><?=$item->count?></td>
                    </tr>
                    <tr>
                        <td style="padding:3px; border: 1px solid black; font-size: 10px">Jami:</td>
                        <td style="padding:3px; border: 1px solid black; font-size: 10px"><?=Yii::$app->formatter->getPrice($item->count*$item->product->sale + $item->deliveryPrice)?></td>
                    </tr>
                    <tr>
                        <td style="padding:3px; border: 1px solid black; font-size: 10px">Operator:</td>
                        <td style="padding:3px; border: 1px solid black; font-size: 10px"><?=$item->operator->username?> <?=$item->operator->id?> / <?=$item->operator->tell?></td>
                    </tr>
                </table>
            </div>

        <?php $c++; endforeach;?>
    <?php endif;?>
    </b>
</div>