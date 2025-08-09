<?php

/* @var $item common\models\Product */
/* @var $status common\models\Product */

use yii\helpers\Url;

?>
<div class="col-xl-3 col-lg-6 col-sm-6">
    <div class="card">
        <div class="card-body">
            <div class="new-arrival-product">
                <div class="new-arrivals-img-contnent">
                    <img class="img-fluid" src="https://<?=Yii::$app->params['og_url_name']['content']?>/backend/web/uploads/product/<?=$item->photo->filename?>" alt="">
                </div>
                <div class="new-arrival-content text-center mt-3">
                    <h4>
                        <a href="<?= Url::to(['/site/offer-detail', 'id' => $item->id])?>">
                            <?=$item->titleTranslate?>
                            <?php if ($item->charity == 1):?>
                                <span class="badge badge-success">+<?=Yii::t("app", "Coin")?></span>
                            <?php endif;?>
                        </a>
                    </h4>
                    <span class="price"><?=Yii::t("app", "Sales")?> <?=Yii::$app->formatter->getPrice($item->sale)?> <br> <?=Yii::t("app", "Payment")?> <?=Yii::$app->formatter->getPrice($item->pay)?> <br> <?=$item->in_stock?>: dona <?=Yii::t("app", "In Stock")?></span>
                    <a href="<?= Url::to(['/site/offer-detail', 'id' => $item->id])?>" class="btn btn-primary"><?=Yii::t("app", "Create a stream")?></a>
                </div>
            </div>
        </div>
    </div>
</div>