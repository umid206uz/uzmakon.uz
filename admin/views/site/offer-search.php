<?php

/* @var $this yii\web\View */
/* @var $model common\models\Product */
/* @var $item common\models\Product */
/* @var $category common\models\Category */
/* @var $categoryOne common\models\Category */
/* @var $pagination yii\data\Pagination */
/* @var $key string */

use admin\widget\standart\StandartWidget;
use yii\widgets\LinkPager;
use yii\helpers\Url;

$this->title = $key;
?>
<!--**********************************
    Content body start
***********************************-->
<div class="content-body">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <form action="<?=Url::to(['/site/offer-search'])?>">
                    <div class="input-group search-area">
                        <input name="key" type="text" class="form-control" placeholder="<?=Yii::t("app", "Search")?>">
                        <button class="btn btn-primary" type="submit"><?=Yii::t("app", "Search")?></button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <?php foreach ($model as $item):?>
                <?= StandartWidget::widget([
                    'model' => $item,
                    'status' => 1
                ])?>
            <?php endforeach;?>
            <nav aria-label="Page navigation example">
                <?= LinkPager::widget([
                    'pagination' => $pagination,
                    'maxButtonCount' => 5,
                    'options' => [
                        'class' => 'pagination pagination-gutter pagination-primary no-bg'
                    ],
                    'pageCssClass' => 'page-item',
                    'nextPageCssClass' => 'page-item page-indicator next',
                    'prevPageCssClass' => 'page-item page-indicator prev',
                    'nextPageLabel' => '<i class="la la-angle-right"></i>',
                    'prevPageLabel' => '<i class="la la-angle-left"></i>',
                    'disabledListItemSubTagOptions' => [
                        'tag' => 'a',
                        'class' => 'page-link'
                    ],
                    'linkOptions' => [
                        'class' => 'page-link'
                    ]
                ]);?>
            </nav>
        </div>
    </div>
</div>
<!--**********************************
    Content body end
***********************************-->