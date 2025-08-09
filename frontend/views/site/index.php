<?php

/* @var $this yii\web\View */
/* @var $categories common\models\Category */
/* @var $category common\models\Category */
/* @var $model common\models\Product */
/* @var $item common\models\Product */
/* @var $slider common\models\Slider */
/* @var $sliderItem common\models\Slider */
/* @var $seo common\models\Pages */
/* @var $counts integer */
/* @var $pagination yii\data\Pagination; */

$this->title = $seo->metaTitleTranslate;

$this->registerJs(<<<JS
let offset = 12; // Birinchi yuklanishdan keyin boshlang'ich offset
let loading = false;
window.onscroll = function() {
    if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 100 && !loading) {
        loading = true;
        document.getElementById('load-more-message').style.display = 'block';

        $.ajax({
            url: '/site/load-more',
            type: 'GET',
            data: { offset: offset },
            success: function(response) {
                $('#product-list').append(response);
                offset += 12; // Keyingi yuklanish uchun offsetni oshiramiz
                loading = false;
                document.getElementById('load-more-message').style.display = 'none';
            },
            error: function() {
                loading = false;
                document.getElementById('load-more-message').style.display = 'none';
            }
        });
    }
};
JS
    , 3)
?>
<main class="main__content_wrapper">
    <section class="shop__section section--padding">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="shop__product--wrapper">
                        <div id="product_grid" class="tab_pane active show">
                            <div class="product__section--inner product__grid--inner">
                                <div id="product-list" class="row row-cols-xl-4 row-cols-lg-3 row-cols-md-3 row-cols-2 mb--n30">
                                    <?= $this->render('_product_items', ['model' => $model]); ?>
                                </div>
                            </div>
                        </div>
                        <div id="load-more-message" style="text-align:center; display:none;">Yuklanmoqda...</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>