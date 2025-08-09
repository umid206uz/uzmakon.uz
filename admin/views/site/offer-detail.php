<?php

/* @var $this yii\web\View */
/* @var $product common\models\Product */
/* @var $model admin\models\Stream */
/* @var $photo common\models\Photos */

use admin\models\Stream;
use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;

$this->title = $product->metaTitleTranslate;
?>
<!--**********************************
    Content body start
***********************************-->
<div class="content-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-3 col-lg-6  col-md-6 col-xxl-5 ">
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <?php $c = 1; foreach ($product->photos as $item):?>
                                        <div role="tabpanel" class="tab-pane fade <?=($c == 1) ? "show active" : ""?>" id="<?=$item->id?>">
                                            <img class="img-fluid" src="https://<?=Yii::$app->params['og_url_name']['content']?>/backend/web/uploads/product/<?=$item->filename?>" alt="">
                                        </div>
                                        <?php $c++; endforeach;?>
                                </div>
                                <div class="tab-slide-content new-arrival-product mb-4 mb-xl-0">
                                    <!-- Nav tabs -->
                                    <ul class="nav slide-item-list mt-3" role="tablist">
                                        <?php $c = 1; foreach ($product->photos as $item):?>
                                            <li role="presentation" <?=($c == 1) ? "class='show'" : ""?>>
                                                <a href="#<?=$item->id?>" role="tab" data-bs-toggle="tab">
                                                    <img class="img-fluid" src="https://<?=Yii::$app->params['og_url_name']['content']?>/backend/web/uploads/product/<?=$item->filename?>" alt="" width="50">
                                                </a>
                                            </li>
                                            <?php $c++; endforeach;?>
                                    </ul>
                                </div>
                            </div>
                            <!--Tab slider End-->
                            <div class="col-xl-9 col-lg-6  col-md-6 col-xxl-7 col-sm-12">
                                <div class="product-detail-content">
                                    <!--Product details-->
                                    <div class="new-arrival-content pr">
                                        <h4><?=$product->titleTranslate?></h4>
                                        <div class="d-table mb-2">
                                            <p class="price float-start d-block"><?=Yii::t("app", "Sales")?> -> <?=number_format($product->sale)?> <?=Yii::t("app", "sum")?></p>
                                            <br>
                                            <p class="price float-start d-block"><?=Yii::t("app", "Payment")?> -> <?=number_format($product->pay)?> <?=Yii::t("app", "sum")?></p>
                                        </div>
                                        <p><?=Yii::t("app", "Availability")?>: <span class="item"> <?=$product->in_stock?>: dona <span class="item"> <?=Yii::t("app", "In Stock")?> <i class="fa fa-shopping-basket"></i></span>
                                        </p>
                                        <p>Product tags:&nbsp;&nbsp;
                                            <?php foreach ($product->tags as $tag):?>
                                                <span class="badge badge-success light"><?=$tag->tag->name?></span>
                                            <?php endforeach;?>
                                        </p>
                                        <p class="text-content"><?=$product->descriptionTranslate?></p>
                                        <div class="d-flex align-items-end flex-wrap mt-4">
                                            <!--Quantity start-->
                                            <?php $form = ActiveForm::begin(); ?>
                                            <?= $form->field($model, 'product_id')->hiddenInput(['value' => $product->id])->label(false) ?>
                                            <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'placeholder' => Yii::t("app", "For example, channel name"), 'class' => 'form-control']) ?>
                                            <?= $form->field($model, 'link')->widget(Select2::classname(), [
                                                'data' => [
                                                    Stream::THROUGH_THE_BOT => Yii::t("app", "Through the bot"),
                                                    Stream::THROUGH_THE_SITE => Yii::t("app", "Through the site"),
                                                    Stream::THROUGH_THE_SITE_AND_THE_BOT => Yii::t("app", "Through the site and the bot"),
                                                ],
                                                'language' => 'uz',
                                                'options' => [
                                                    'placeholder' => Yii::t("app", "Select a post link type."),
                                                    'class' => 'form-control'
                                                ],
                                                'pluginOptions' => [
                                                    'allowClear' => true
                                                ],
                                            ]);
                                            ?>
                                            <!--Quanatity End-->
                                            <div class="shopping-cart  mb-2 me-3">
                                                <button class="btn btn-primary" type="submit"><?=Yii::t("app", "Save Changes")?></button>
                                            </div>
                                            <?php ActiveForm::end(); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--**********************************
    Content body end
***********************************-->