<?php
namespace operator\widget\alert;

use yii\bootstrap\Widget;

class AlertWidget extends Widget
{
    public function init(){}

    public function run() {

        return $this->render('alert');
    }

}