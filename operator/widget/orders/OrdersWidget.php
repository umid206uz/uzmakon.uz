<?php
namespace operator\widget\order;

use yii\bootstrap\Widget;

class OrdersWidget extends Widget
{
    public $model;

    public function init(){}

    public function run() {

        return $this->render('orders', [
            'item' => $this->model
        ]);
    }

}