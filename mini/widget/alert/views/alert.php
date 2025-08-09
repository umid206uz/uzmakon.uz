<?php
use dominus77\sweetalert2\Alert;
use yii\helpers\Url;
use yii\web\JsExpression;
?>
<?php if (Yii::$app->session->hasFlash('success')): ?>
    <?= Alert::widget([
        'options' => [
            'title' => Yii::$app->session->getFlash('success'),
            'text' => Yii::$app->session->getFlash('success'),
            'icon' => 'success',
            'showCancelButton' => true,
            'confirmButtonText' => 'Yopish',
            'cancelButtonText' => 'Yana mahsulot qo\'shish',
            'cancelButtonColor' => '#3085d6',
        ],
        'callback' => new JsExpression("
            function(result) {
                if (result.dismiss === Swal.DismissReason.cancel) {
                    window.location.href = '" . Url::to(['site/create-product', 'id' => Yii::$app->session->getFlash('success')]) . "';
                }
            }
        "),
    ]);?>
<?php endif; ?>