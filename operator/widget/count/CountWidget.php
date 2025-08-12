<?php
namespace operator\widget\count;

use yii\bootstrap\Widget;

class CountWidget extends Widget
{
    public $model;
    public $count;
    public $pagination;

    public function init(){}

    public function run() {

        return $this->render('count', [
            'model' => $this->model,
            'count' => $this->count,
            'pagination' => $this->pagination
        ]);
    }

}