<?php
namespace frontend\widget\item;

use yii\base\Widget;

class ItemWidget extends Widget
{
    public $model;
    public $status;

    public function init(){}

    public function run() {
        return $this->render('item', [
        	'item' => $this->model,
        	'status' => $this->status
        ]);
    }

}