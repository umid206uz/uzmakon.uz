<?php
namespace common\jobs;

use yii\base\BaseObject;
use yii\queue\JobInterface;

class SendTelegramJob extends BaseObject implements JobInterface
{
    public $orderId;
    public $newStatus;

    public function execute($queue)
    {
        \Yii::info("Job ishladi: " . $this->message, 'queue');
        // Bu yerda kerakli kodni bajaramiz (masalan, email jo‘natish)
    }
}
?>