<?php
namespace admin\widget\standart;

use yii\bootstrap\Widget;

class StandartWidget extends Widget
{
    public $model;
    public $status;
    
    public function init(){}

    public function run() {
        
        return $this->render('standart', [
        	'item' => $this->model,
            'status' => $this->status,
        ]);
    }

}