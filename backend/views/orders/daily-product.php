<?php

/* @var $this yii\web\View */
/* @var $model common\models\Orders */
/* @var $item common\models\Orders */

$this->title = Yii::t("app", "Read to delivery products");
?>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><?=Yii::t("app", "Read to delivery products")?></h3>
                </div>

                <div class="box-body">
                    <table class="table table-bordered">
                        <tbody><tr>
                            <th style="width: 10px">#</th>
                            <th><?=Yii::t("app", "Product name")?></th>
                            <th><?=Yii::t("app", "Count")?></th>
                        </tr>
                        <?php $counter = 1; $product_amount = 0; foreach ($model as $item):?>
                            <tr>
                                <td><?=$counter?>.</td>
                                <td><?=$item->product->titleTranslate?></td>
                                <td><?=$item->count?></td>
                            </tr>
                            <?php $counter++; $product_amount = $product_amount + $item->count; endforeach;?>
                        <tr>
                            <td>#</td>
                            <td>Jami:</td>
                            <td><?=$product_amount?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>