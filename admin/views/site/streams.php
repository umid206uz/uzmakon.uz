<?php

/* @var $this yii\web\View */
/* @var $model admin\models\Stream */
/* @var $item admin\models\Stream */
/* @var $url string */

use admin\widget\alert\AlertWidget;
use yii\helpers\Html;

$this->title = Yii::t("app", "Streams");

$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js');
$this->registerJs("var clipboard = new ClipboardJS('.btn')", 3);
?>
<!--**********************************
    Content body start
***********************************-->
<div class="content-body">
    <div class="container-fluid">
        <?= AlertWidget::widget()?>
        <!-- row -->
        <div class="row">
            <?php foreach ($model as $item):?>
                <div class="col-lg-4 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <?=$item->product->titleTranslate?>
                        </div>
                        <div class="card-body">
                            <h4 class="card-title"><?=$item->title?></h4>
                            <div class="form-group">
                                <input id="i<?= $item->key?>" class="form-control" type="text" value="<?='https://' . Yii::$app->params['og_url_name']['content'] . '/link/' . $item->key?>">
                            </div>
                            <?= Html::a(Yii::t('app', ' <i class="la la-trash"></i>'),
                                [
                                    '/site/delete-stream',
                                    'id' => $item->id
                                ],
                                [
                                    'class' => 'btn btn-danger',
                                    'data' => [
                                        'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                        'method' => 'post',
                                    ],
                                ]) ?>
                            <?= Html::button(Yii::t('app', ' <i class="la la-copy"></i>'),
                                [
                                    'class' => 'btn btn-success',
                                    'data' => [
                                        'clipboard-target' => '#i' . $item->key
                                    ]
                                ]) ?>
                            <a class="btn btn-primary" href="tg://resolve?domain=UzMakonPostBot&amp;start=<?=$item->key?>">
                                <i class="la la-send"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach;?>
        </div>
    </div>
</div>
<!--**********************************
    Content body end
***********************************-->