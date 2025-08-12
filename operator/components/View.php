<?php

namespace mini\components;

class View extends \yii\web\View
{
    public function getImageUrl($name)
    {
        return $this->getAssetManager()->getBundle('\mini\assets\AppAsset')->baseUrl . '/' . $name;
    }
}