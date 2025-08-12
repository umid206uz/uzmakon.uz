<?php

namespace operator\components;

class View extends \yii\web\View
{
    public function getImageUrl($name)
    {
        return $this->getAssetManager()->getBundle('\operator\assets\AppAsset')->baseUrl . '/' . $name;
    }
}