<?php

/* @var $model common\models\Product */
/* @var $item common\models\Product */

use frontend\widget\item\ItemWidget;
?>
<?php foreach ($model as $item): ?>
    <?= ItemWidget::widget(['model' => $item, 'status' => 1]) ?>
<?php endforeach; ?>