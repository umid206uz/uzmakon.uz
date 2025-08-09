<?php

/* @var $item common\models\Product */
/* @var $status common\models\Product */

use yii\helpers\Url;

?>
<?php if ($status == 2):?>
<div class="swiper-slide">
<?php endif;?>
<div class="col mb-30">
    <div class="product__items ">
        <div class="product__items--thumbnail">
            <a class="product__items--link" href="<?= Url::to(['/site/product', 'id' => $item->id])?>">
                <img class="product__items--img product__primary--img" src="/backend/web/uploads/product/<?=($item->photo === null || file_exists("/backend/web/uploads/product/" . $item->photo->filename)) ? "no.png" : $item->photo->filename?>" alt="product-img">
                <img class="product__items--img product__secondary--img" src="/backend/web/uploads/product/<?=($item->photo === null || file_exists("/backend/web/uploads/product/" . $item->photo->filename)) ? "no.png" : $item->photo->filename?>" alt="product-img">
            </a>
        </div>
        <div class="product__items--content">
            <span class="product__items--content__subtitle"><?=$item->category->titleTranslate?></span>
            <h3 class="product__items--content__title h4">
                <a href="<?= Url::to(['/site/product', 'id' => $item->id])?>"><?=$item->titleTranslate?></a>
            </h3>
            <div class="product__items--price">
                <span class="current__price"><?=Yii::$app->formatter->getPrice($item->sale)?></span>
            </div>
            <ul class="product__items--action d-flex">
                <li class="product__items--action__list">
                    <a class="reviews__comment--btn text-white primary__btn" href="<?= Url::to(['/site/product', 'id' => $item->id])?>">
                        <?=Yii::t("app", "Read More")?>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<?php if ($status == 2):?>
</div>
<?php endif;?>