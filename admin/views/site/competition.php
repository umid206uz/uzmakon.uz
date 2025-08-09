<?php

/* @var $this yii\web\View */
/* @var $model common\models\Post */
/* @var $users common\models\Orders */
/* @var $user common\models\Orders */

$this->title = Yii::t("app", "Competition");
?>
<div class="content-body">
    <div class="container-fluid">
        <div class="row">

            <div class="col-xl-12">
                <div class="card mb-3">
                    <img class="card-img-top img-fluid" src="/backend/web/uploads/post/<?= $model->filename?>" alt="Card image cap">
                    <div class="card-header">
                        <h5 class="card-title"><?=$model->titleTranslate?></h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text"> <?=$model->descriptionTranslate?></p>
                        <p class="card-text text-dark"><?=$model->started_date?> - <?=$model->closed_date?></p>
                    </div>
                </div>
            </div>

            <div class="col-xl-12">
                <div class="card message-bx">
                    <div class="card-header d-sm-flex d-block shadow-sm">
                        <div>
                            <h4 class="fs-20 mb-0 font-w600 text-black mb-sm-0 mb-2">
                                <?=Yii::t('app', 'Top ({count}) of the competition', [
                                    'count' => $model->gold,
                                ])?>
                            </h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php foreach ($users as $user):?>
                            <div class="media mb-4">
                                <div class="image-bx mr-sm-4 mr-2">
                                    <img width="70px" src="<?=$user->user->avatar?>" alt="" class="rounded-circle img-1">
                                    <span class="active"></span>
                                </div>
                                <div class="media-body d-sm-flex justify-content-between d-block align-items-center">
                                    <div class="mr-sm-3 mr-0">
                                        <h6 class="fs-16 font-w600 mb-sm-2 mb-0">
                                            <a href="#" class="text-black"><?=$user->user->fullName?>. <?=$user->user->occupation?></a>
                                        </h6>
                                        <p class="text-black mb-sm-3 mb-1"><?=Yii::t("app", "Sold orders")?>: </p>
                                    </div>
                                    <a href="#" class="btn btn-primary light rounded mt-sm-0 mt-2"><?=$user->count?></a>
                                </div>
                            </div>
                        <?php endforeach;?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>