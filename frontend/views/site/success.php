<?php

/* @var $this \yii\web\View */
/* @var $product common\models\Product */

$this->title = $product->metaTitleTranslate;
?>
<!-- 404 area start -->
<div class="ltn__404-area ltn__404-area-1 mb-120">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="error-404-inner text-center">
                    <h1 class="error-404-title d-none">404</h1>
                    <h2><?=Yii::t("app", "Thank you! Your order has been successfully accepted!")?></h2>
                    <!-- <h3>Oops! Looks like something going rong</h3> -->
                    <p><?=Yii::t("app", "Expect, in the near future our managers will contact you using the specified contact information!")?></p>
                    <div class="btn-wrapper">
                        <a href="/" class="btn btn-transparent"><i class="fas fa-long-arrow-alt-left"></i> <?=Yii::t("app", "Back to home")?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- 404 area end -->

<!-- CALL TO ACTION START (call-to-action-6) -->
<div class="ltn__call-to-action-area call-to-action-6 before-bg-bottom" data-bs-bg="/frontend/web/template/img/1.jpg--">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="call-to-action-inner call-to-action-inner-6 ltn__secondary-bg position-relative text-center---">
                    <div class="coll-to-info text-color-white">
                        <h1>Eng yaxshilari faqat siz uchun!</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- CALL TO ACTION END -->