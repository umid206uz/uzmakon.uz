<?php

/* @var $this yii\web\View */
/* @var $searchModel admin\models\AdminOrdersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use common\models\Click;
use common\models\Orders;
use kartik\grid\GridView;

$this->title = Yii::t("app", "Orders by stream");
?>
<!--**********************************
    Content body start
***********************************-->
<div class="content-body">
    <div class="container-fluid">
        <!-- row -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><?=Yii::t("app", "Orders by stream")?></h4>
                    </div>
                    <div class="card-body">
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'responsiveWrap' => false,
                            'pager' => [
                                'maxButtonCount' => 4,
                                'options' => [
                                    'class' => 'pagination pagination-gutter'
                                ],
                                'pageCssClass' => 'page-item',
                                'nextPageCssClass' => 'page-item next',
                                'prevPageCssClass' => 'page-item prev',
                                'nextPageLabel' => '<i class="la la-angle-right"></i>',
                                'prevPageLabel' => '<i class="la la-angle-left"></i>',
                                'disabledListItemSubTagOptions' => [
                                    'tag' => 'a',
                                    'class' => 'page-link'
                                ],
                                'linkOptions' => [
                                    'class' => 'page-link'
                                ]
                            ],
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                'title',
                                [
                                    'header' => Yii::t("app", "Visit"),
                                    'value' => function($model){
                                        return Click::find()->where(['user_id' => Yii::$app->user->id, 'oqim_id' => $model->id])->count();
                                    }
                                ],
                                [
                                    'header' => Yii::t("app", "All orders"),
                                    'value' => function($model){
                                        return Orders::find()->where(['user_id' => Yii::$app->user->id, 'oqim_id' => $model->id])->count();
                                    }
                                ],
                                [
                                    'header' => Yii::t("app", "New"),
                                    'value' => function($model){
                                        return Orders::find()->where(['user_id' => Yii::$app->user->id, 'oqim_id' => $model->id, 'status' => Orders::STATUS_NEW])->count();
                                    }
                                ],
                                [
                                    'header' => Yii::t("app", "Ready for delivery"),
                                    'value' => function($model){
                                        return Orders::find()->where(['user_id' => Yii::$app->user->id, 'oqim_id' => $model->id, 'status' => Orders::STATUS_READY_TO_DELIVERY])->count();
                                    }
                                ],
                                [
                                    'header' => Yii::t("app", "Then takes"),
                                    'value' => function($model){
                                        return Orders::find()->where(['user_id' => Yii::$app->user->id, 'oqim_id' => $model->id, 'status' => Orders::STATUS_THEN_TAKES])->count();
                                    }
                                ],
                                [
                                    'header' => Yii::t("app", "Hold"),
                                    'value' => function($model){
                                        return Orders::find()->where(['user_id' => Yii::$app->user->id, 'oqim_id' => $model->id, 'status' => Orders::STATUS_HOLD])->count();
                                    }
                                ],
                                [
                                    'header' => Yii::t("app", "Preparing"),
                                    'value' => function($model){
                                        return Orders::find()->where(['user_id' => Yii::$app->user->id, 'oqim_id' => $model->id, 'status' => Orders::STATUS_PREPARING])->count();
                                    }
                                ],
                                [
                                    'header' => Yii::t("app", "Being delivered"),
                                    'value' => function($model){
                                        return Orders::find()->where(['user_id' => Yii::$app->user->id, 'oqim_id' => $model->id, 'status' => Orders::STATUS_BEING_DELIVERED])->count();
                                    }
                                ],
                                [
                                    'header' => Yii::t("app", "Delivered"),
                                    'value' => function($model){
                                        return Orders::find()->where(['user_id' => Yii::$app->user->id, 'oqim_id' => $model->id, 'status' => Orders::STATUS_DELIVERED])->count();
                                    }
                                ],
                                [
                                    'header' => Yii::t("app", "Returned"),
                                    'value' => function($model){
                                        return Orders::find()->where(['user_id' => Yii::$app->user->id, 'oqim_id' => $model->id, 'status' => Orders::STATUS_RETURNED])->count();
                                    }
                                ],
                                [
                                    'header' => Yii::t("app", "Archive"),
                                    'value' => function($model){
                                        return Orders::find()->where(['user_id' => Yii::$app->user->id, 'oqim_id' => $model->id, 'status' => Orders::STATUS_RETURNED_OPERATOR])->count();
                                    }
                                ],
                                [
                                    'header' => Yii::t("app", "Black list"),
                                    'value' => function($model){
                                        return Orders::find()->where(['user_id' => Yii::$app->user->id, 'oqim_id' => $model->id, 'status' => Orders::STATUS_BLACK_LIST])->count();
                                    }
                                ],
                                [
                                    'header' => Yii::t("app", "Earnings"),
                                    'value' => function($model){
                                        $amount = Orders::find()->where(['user_id' => Yii::$app->user->id, 'oqim_id' => $model->id, 'status' => Orders::STATUS_DELIVERED])->all();
                                        $total = 0;
                                        foreach ($amount as $key){
                                            $total = $total + $key->product->pay;
                                        }
                                        return Yii::$app->formatter->getPrice($total);
                                    }
                                ],
                            ],
                        ]); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--**********************************
    Content body end
***********************************-->