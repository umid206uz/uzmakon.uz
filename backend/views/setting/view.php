<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Setting */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Settings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>
<div class="setting-view container box">

    <br>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Admin bot token activate',
            Url::to('https://api.telegram.org/bot' . $model->admin_bot_token . '/setWebhook?url=' . Yii::$app->request->hostInfo . '/bot/admin-bot', true),
            [
                'class' => 'btn btn-success',
                'target' => '_blank'
            ])
        ?>
        <?= Html::a('Orders bot token activate',
            Url::to('https://api.telegram.org/bot' . $model->orders_bot_token . '/setWebhook?url=' . Yii::$app->request->hostInfo . '/bot/orders-bot', true),
            [
                'class' => 'btn btn-success',
                'target' => '_blank'
            ])
        ?>
        <?= Html::a('Post bot token activate',
            Url::to('https://api.telegram.org/bot' . $model->post_bot_token . '/setWebhook?url=' . Yii::$app->request->hostInfo . '/bot/post-bot', true),
            [
                'class' => 'btn btn-success',
                'target' => '_blank'
            ])
        ?>
        <?= Html::a('Get order bot token activate',
            Url::to('https://api.telegram.org/bot' . $model->get_order_bot_token . '/setWebhook?url=' . Yii::$app->request->hostInfo . '/bot/get-order', true),
            [
                'class' => 'btn btn-success',
                'target' => '_blank'
            ])
        ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'title',
            'title_ru',
            'title_en',
            'addres',
            'addres_ru',
            'addres_en',
            'copyright',
            'copyright_ru',
            'mail',
            'facebook',
            'instagram',
            'telegram',
            'youtube',
            'description:ntext',
            'description_ru:ntext',
            'description_en:ntext',
            'logo',
            'logo_bottom',
            'favicon',
            'open_graph_photo',
            'admin_bot_token',
            'orders_bot_token',
            'post_bot_token',
        ],
    ]) ?>

</div>
