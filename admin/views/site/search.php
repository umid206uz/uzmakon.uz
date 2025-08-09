<?php
/* @var $this yii\web\View */
/* @var $model common\models\Product */
/* @var $item common\models\Product */
/* @var $seo common\models\Pages */
/* @var $counts integer */
/* @var $key string */
/* @var $pagination yii\data\Pagination; */

$this->title = $key;

use frontend\widget\item\ItemWidget;
use yii\widgets\LinkPager;
use mini\widget\count\CountWidget;
?>
<main class="main__content_wrapper">
    <!-- Start shop section -->
    <section class="shop__section section--padding">
        <div class="container-fluid">
            <div class="shop__header bg__gray--color d-flex align-items-center justify-content-between mb-30">
                <p class="product__showing--count">
                    <?= CountWidget::widget([
                        'model' => $model,
                        'count' => $counts,
                        'pagination' => $pagination
                    ])?>
                </p>
            </div>
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="shop__product--wrapper">
                        <div class="tab_content">
                            <div id="product_grid" class="tab_pane active show">
                                <div class="product__section--inner product__grid--inner">
                                    <div class="row row-cols-xl-4 row-cols-lg-3 row-cols-md-3 row-cols-2 mb--n30">
                                        <?php foreach ($model as $item):?>
                                            <!-- Single Top Product Card -->
                                            <?= ItemWidget::widget([
                                                'model' => $item,
                                                'status' => 1
                                            ])?>
                                        <?php endforeach;?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pagination__area bg__gray--color">
                            <nav class="pagination justify-content-center">
                                <?=  LinkPager::widget([
                                    'pagination' => $pagination,
                                    'options' => [
                                        'class' => 'pagination__wrapper d-flex align-items-center justify-content-center'
                                    ],
                                    'pageCssClass' => 'pagination__list',
                                    'nextPageCssClass' => 'pagination__list next',
                                    'prevPageCssClass' => 'pagination__list prev',
                                    'nextPageLabel' => '<svg xmlns="http://www.w3.org/2000/svg" width="22.51" height="20.443" viewBox="0 0 512 512">
                                                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="48" d="M268 112l144 144-144 144M392 256H100"/>
                                                        </svg>
                                                        <span class="visually-hidden">pagination arrow</span>',
                                    'prevPageLabel' => '<svg xmlns="http://www.w3.org/2000/svg"  width="22.51" height="20.443" viewBox="0 0 512 512">
                                                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="48" d="M244 400L100 256l144-144M120 256h292"/>
                                                        </svg>
                                                        <span class="visually-hidden">pagination arrow</span>',
                                    'disabledListItemSubTagOptions' => [
                                        'tag' => 'a',
                                        'class' => 'pagination__item--arrow link'
                                    ],
                                    'linkOptions' => [
                                        'class' => 'pagination__item link'
                                    ]
                                ]); ?>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End shop section -->
</main>