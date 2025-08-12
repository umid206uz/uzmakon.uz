<?php
namespace operator\widget\order;

use yii\bootstrap\Widget;

class OrderWidget extends Widget
{
    public $model;

    public function init(){}

    public function run() {

        return $this->render('order', [
            'item' => $this->model
        ]);
    }

}