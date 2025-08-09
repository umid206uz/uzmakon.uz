<?php

/* @var $this \yii\web\View */
/* @var $product common\models\Product */
/* @var $item common\models\Product */
/* @var $model common\models\Orders */
/* @var $photo common\models\Photos */

use yii\bootstrap\ActiveForm;
use frontend\widget\item\ItemWidget;
use yii\widgets\MaskedInput;

$this->title = $product->metaTitleTranslate;
$this->registerJs(<<<JS
$('#app').on('beforeSubmit', function () {
     $('#submitter').prop('disabled', true);
});
JS
    , 3)
?>
<?php if (Yii::$app->session->hasFlash('success')):?>
    <main class="main__content_wrapper">

        <!-- Start error section -->
        <section class="error__section section--padding">
            <div class="container">
                <div class="row row-cols-1">
                    <div class="col">
                        <div class="error__content text-center">
                            <h2 class="error__content--title"><?= Yii::$app->session->getFlash('success') ?></h2>
                            <p class="error__content--desc"><?=Yii::t("app", "Expect, in the near future our managers will contact you using the specified contact information!")?></p>
                            <a class="error__content--btn primary__btn" href="/"><?=Yii::t("app", "Back to home")?></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End error section -->

        <!-- Start product section -->
        <section class="product__section product__section--style3 section--padding">
            <div class="container product3__section--container">
                <div class="section__heading text-center mb-50">
                    <h2 class="section__heading--maintitle"><?=Yii::t("app","SIMILAR PRODUCTS")?></h2>
                </div>
                <div class="product__section--inner product__swiper--column4__activation swiper">
                    <div class="swiper-wrapper">
                        <?php foreach ($product->latest as $item):?>
                            <!-- Single Product Slide -->
                            <?= ItemWidget::widget([
                                'model' => $item,
                                'status' => 2
                            ])?>
                        <?php endforeach;?>
                    </div>
                    <div class="swiper__nav--btn swiper-button-next"></div>
                    <div class="swiper__nav--btn swiper-button-prev"></div>
                </div>
            </div>
        </section>
        <!-- End product section -->

    </main>
<?php else:?>
<main class="main__content_wrapper">

    <!-- Start product details tab section -->
    <section class="product__details--tab__section section--padding">
        <div class="container">
            <div class="row row-cols-1">
                <div class="col">
                    <div class="product__details--tab__inner border-radius-10">
                        <div class="tab_content">
                            <div id="reviews" class="tab_pane active show">
                                <div class="product__reviews">
                                    <div id="writereview" class="reviews__comment--reply__area">
                                        <?php $form = ActiveForm::begin([
                                            'id' => 'app'
                                        ]); ?>
                                        <h3 class="reviews__comment--reply__title mb-15"><?= Yii::t("app", "Fill out the order form") ?></h3>
                                        <div class="row">
                                            <div class="col-12 mb-10">
                                                <?= $form->field($model, 'full_name')->textInput(['placeholder' => \Yii::t("app", "Full name"), 'class' => 'reviews__comment--reply__input'])->label(Yii::t("app", "Full name"))?>
                                            </div>
                                            <div class="col-12 mb-10">
                                                <?= $form->field($model, 'phone')->widget(MaskedInput::className(), [
                                                    'mask' => '+\\9\\98(99)-999-99-99',
                                                    'options' => [
                                                        'placeholder' => \Yii::t("app", "Phone number"),
                                                        'class' => 'reviews__comment--reply__input'
                                                    ]
                                                ])->label(Yii::t("app", "Phone number")); ?>
                                            </div>
                                        </div>
                                        <button id="submitter" class="reviews__comment--btn text-white primary__btn" data-hover="Submit" type="submit"><?=Yii::t("app", "To order")?></button>
                                        <?php ActiveForm::end(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End product details tab section -->
    
    <!-- Start product details section -->
    <section class="product__details--section section--padding">
        <div class="container">
            <div class="row row-cols-lg-2 row-cols-md-2">
                <div class="col">
                    <div class="product__details--media">
                        <div class="product__media--preview  swiper">
                            <div class="swiper-wrapper">
                                <?php foreach ($product->photos as $photo):?>
                                <div class="swiper-slide">
                                    <div class="product__media--preview__items">
                                        <a class="product__media--preview__items--link glightbox" data-gallery="product-media-preview" href="/backend/web/uploads/product/<?=$photo->filename?>">
                                            <img class="product__media--preview__items--img" src="/backend/web/uploads/product/<?=$photo->filename?>" alt="product-media-img">
                                        </a>
                                        <div class="product__media--view__icon">
                                            <a class="product__media--view__icon--link glightbox" href="/backend/web/uploads/product/<?=$photo->filename?>" data-gallery="product-media-preview">
                                                <svg class="product__media--view__icon--svg" xmlns="http://www.w3.org/2000/svg" width="22.51" height="22.443" viewBox="0 0 512 512">
                                                    <path d="M221.09 64a157.09 157.09 0 10157.09 157.09A157.1 157.1 0 00221.09 64z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></path>
                                                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M338.29 338.29L448 448"></path>
                                                </svg>
                                            </a>
                                        </div>
                                        <div class="product__media--view__icon media__play">
                                            <a class="media__play--icon__link glightbox" data-gallery="video" href="https://vimeo.com/115041822">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" width="35.51" height="35.443" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <span class="visually-hidden">play</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach;?>
                            </div>
                        </div>
                        <div class="product__media--nav swiper">
                            <div class="swiper-wrapper">
                                <?php foreach ($product->photos as $photo):?>
                                <div class="swiper-slide">
                                    <div class="product__media--nav__items">
                                        <img class="product__media--nav__items--img" src="/backend/web/uploads/product/<?=$photo->filename?>" alt="product-nav-img">
                                    </div>
                                </div>
                                <?php endforeach;?>
                            </div>
                            <div class="swiper__nav--btn swiper-button-next"></div>
                            <div class="swiper__nav--btn swiper-button-prev"></div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="product__details--info">
                        <form action="#">
                            <h2 class="product__details--info__title mb-15"><?=$product->titleTranslate?></h2>
                            <div class="product__details--info__price mb-10">
                                <span class="current__price"><?=number_format($product->sale)?> <?=Yii::t("app", "sum")?></span>
                                <span class="price__divided"></span>
                                <span class="old__price"><?=number_format($product->price)?> <?=Yii::t("app", "sum")?></span>
                            </div>
                            <p class="product__details--info__desc mb-15"><?=$product->descriptionTranslate?></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End product details section -->

    <!-- Start product section -->
    <section class="product__section product__section--style3 section--padding">
        <div class="container product3__section--container">
            <div class="section__heading text-center mb-50">
                <h2 class="section__heading--maintitle"><?=Yii::t("app", "SIMILAR PRODUCTS")?></h2>
            </div>
            <div class="product__section--inner product__swiper--column4__activation swiper">
                <div class="swiper-wrapper">
                    <?php foreach ($product->latest as $item):?>
                        <!-- Single Product Slide -->
                        <?= ItemWidget::widget([
                            'model' => $item,
                            'status' => 2
                        ])?>
                    <?php endforeach;?>
                </div>
                <div class="swiper__nav--btn swiper-button-next"></div>
                <div class="swiper__nav--btn swiper-button-prev"></div>
            </div>
        </div>
    </section>
    <!-- End product section -->

</main>
<?php endif;?>