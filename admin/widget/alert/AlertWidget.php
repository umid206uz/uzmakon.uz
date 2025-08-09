<?php
namespace admin\widget\alert;

use yii\base\Widget;

class AlertWidget extends Widget
{
    public function init(){}

    public function run() {
        return $this->render('alert');
    }

}