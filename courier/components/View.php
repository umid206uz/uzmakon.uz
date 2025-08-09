<?php

namespace courier\components;

class View extends \yii\web\View
{
    public function getImageUrl($name)
    {
        return $this->getAssetManager()->getBundle('\courier\assets\AppAsset')->baseUrl . '/' . $name;
    }
}