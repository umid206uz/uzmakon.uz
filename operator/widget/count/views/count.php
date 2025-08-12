<?php
/* @var $pagination yii\data\Pagination */
/* @var $count common\models\Orders */
/* @var $model common\models\Orders */

if(!empty($model)){
    $value = count($model);
    if ($value <= 0) {
        return '';
    }
    $begin = $pagination->getPage() * $pagination->pageSize + 1;
    $end = $begin + $value - 1;
    if ($begin > $end) {
        $begin = $end;
    }
    echo $count .' ta natijadan '.$begin.'-'.$end.' ko`rsatilmoqda';
}
?>