<?php

use yii\bootstrap\Modal;

Modal::begin([
    'header' => Yii::t("app", "Delivery Price"),
    'id' => "modalDeliveryPrice",
    "size" => "modal-lg",
]);

echo "<div id='modalContentDeliveryPrice'></div>";

Modal::end();
?>
<?php
Modal::begin([
    'header' => Yii::t("app", "Add a picture"),
    'id' => "modalAddPictureToProduct",
    "size" => "modal-lg",
]);

echo "<div id='modalContentAddPictureToProduct'></div>";

Modal::end();
?>
<?php
Modal::begin([
    'header' => Yii::t("app", "Add a video"),
    'id' => "modalAddVideoToProduct",
    "size" => "modal-lg",
]);

echo "<div id='modalContentAddVideoToProduct'></div>";

Modal::end();
?>