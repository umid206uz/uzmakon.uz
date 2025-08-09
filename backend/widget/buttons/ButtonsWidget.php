<?php
namespace backend\widget\buttons;

use yii\bootstrap\Widget;

class ButtonsWidget extends Widget
{
    public function init(){}

    public function run() {

        return $this->render('buttons');
    }

}