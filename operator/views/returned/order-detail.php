<?php

/* @var $this yii\web\View */
/* @var $model common\models\Orders */
/* @var $history common\models\OrderLog */
/* @var $history_item common\models\OrderLog */
?>
<?php if ($model->operator_id == Yii::$app->user->id):?>
    <div class="row">
        <?php if ($history = $model->history):?>
            <div class="col-md-12">
                <div class="table-scrollable">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th> # </th>
                            <th> <?=Yii::t('app', 'User')?> </th>
                            <th> <?=Yii::t('app', 'Old status')?> </th>
                            <th> <?=Yii::t('app', 'New status')?> </th>
                            <th> <?=Yii::t('app', 'Practice date')?> </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $c = 1; foreach ($history as $history_item):?>
                            <tr>
                                <td> <?=$c?> </td>
                                <td> <?=$history_item->user->username?> </td>
                                <td>
                                    <span class="label label-sm <?=Yii::$app->status->colorForOperatorOrCourierStatus($history_item->old_status)?>"> <?=Yii::$app->status->allStatusTranslate($history_item->old_status)?> </span>
                                </td>
                                <td>
                                    <span class="label label-sm <?=Yii::$app->status->colorForOperatorOrCourierStatus($history_item->new_status)?>"> <?=Yii::$app->status->allStatusTranslate($history_item->new_status)?> </span>
                                </td>
                                <td> <?=Yii::$app->formatter->getDate($history_item->time)?> </td>
                            </tr>
                            <?php $c++; endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif;?>
        <!-- Order information -->
        <div class="col-md-6">
            <div class="product-card" style="display: flex; flex-direction: column; align-items: center; padding: 20px; background-color: white; margin-bottom: 15px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);">

                <!-- Product Image -->
                <div class="product-image" style="width: 100%; height: 250px; overflow: hidden; border-radius: 12px; margin-bottom: 15px;">
                    <img src="https://inbaza.uz/backend/web/uploads/product/<?=$model->product->photo->filename?>" alt="Product Image" style="width: 100%; height: 100%; object-fit: cover;">
                </div>

                <!-- Product Info -->
                <div class="product-info" style="text-align: center;">
                    <h4 style="color: #333; margin-bottom: 8px;"><?=$model->product->title?></h4>
                    <span class="badge" style="background-color: #ffab40; color: white; padding: 5px 10px; font-size: 14px;"><?=$model->product->category->title?></span>
                    <span class="badge" style="background-color: #379ed6; color: white; padding: 5px 10px; font-size: 14px;"><?=Yii::$app->formatter->getPrice($model->product->sale)?></span>
                </div>

                <!-- Product Description -->
                <div class="product-description" style="margin-top: 15px; padding: 10px 15px; background-color: #f9f9f9; border-radius: 8px; text-align: justify;">
                    <?=$model->product->description?>
                </div>
            </div>
        </div>

        <!-- Client & Delivery -->
        <div class="col-md-6">
            <div class="order-card" style="padding: 15px; border-left: 4px solid #667eea; margin-bottom: 15px; background-color: white; border-radius: 8px;">
                <h5 style="color: #667eea; margin-bottom: 10px;"><i class="icon-tag"></i> Order Information</h5>
                <p><strong><?=Yii::t("app","Product Name")?>:</strong> <span id="product_name"><?=$model->product->title?></span></p>
                <p><strong><?=Yii::t("app","Count")?>:</strong> <span id="count"><?=$model->count?></span></p>
                <p><strong><?=Yii::t("app","Status")?>:</strong> <span id="status" class="badge badge-<?=Yii::$app->status->colorForOperatorOrCourier($model->status)?>"><?=Yii::$app->status->allStatusTranslate($model->status)?></span></p>
                <p><strong><?=Yii::t("app","Operator")?>:</strong> <span id="operator">John Doe</span></p>
                <p><strong><?=Yii::t("app","Delivery type")?>:</strong> <span id="delivery_type"><?=($model->control_id == 1 ? Yii::t("app","Delivery is paid") : Yii::t("app","Free shipping"))?></span></p>
                <p><strong><?=Yii::t("app","Delivery price")?>:</strong> <span id="delivery_price"><?=Yii::$app->formatter->getPrice($model->competition)?></span></p>
            </div>

            <div class="client-card" style="padding: 15px; border-left: 4px solid #764ba2; margin-bottom: 15px; background-color: white; border-radius: 8px;">
                <h5 style="color: #764ba2; margin-bottom: 10px;"><i class="icon-user"></i> Client & Delivery</h5>
                <p><strong><?=Yii::t("app","Customer")?>:</strong> <span id="client"><?=$model->full_name?></span></p>
                <p><strong><?=Yii::t("app","Address")?>:</strong> <span id="ordered_region"><?=$model->region->name?> <?=$model->district->name?> <?=$model->addres?></span></p>

                <p><strong><?=Yii::t("app","Phone number")?>:</strong> <a href="tel:<?=$model->phone?>" id="customer_phone"><?=Yii::$app->formatter->asPhone($model->phone)?></a></p>
            </div>

            <div class="additional-info-card" style="padding: 15px; border-left: 4px solid #36c5b9; background-color: white; border-radius: 8px;">
                <h5 style="color: #36c5b9; margin-bottom: 10px;"><i class="icon-info"></i> Additional Information</h5>
                <p><strong>Additional Info:</strong> <span id="additional_info">N/A</span></p>
                <p><strong>Additional Phone:</strong> <span id="additional_phone">+1 (234) 567-8902</span></p>
                <p><strong>Additional Address:</strong> <span id="additional_address">1234 Elm Street</span></p>
            </div>
        </div>
    </div>

<?php else:?>
    <div class="row">
        <div class="col-md-6">
            <p><?=Yii::t("app", "Order not accepted")?></p>
        </div>
    </div>
<?php endif;?>