<?php
return [
    'adminEmail' => 'admin@example.com',
    'og_title' => ['property' => 'og:title', 'content' => 'title'],
    'og_site_name' => ['property' => 'og:site_name', 'content' => 'UzMakon.uz'],
    'og_type' => ['property' => 'og:type', 'content' => 'website'],
    'og_description' => ['property' => 'og:description', 'content' => 'description'],
    'og_url' => ['property' => 'og:url', 'content' => Yii::$app->request->hostInfo],
    'og_language_uz' => ['property' => 'og:language_uz', 'content' => '/uz'],
    'og_language_ru' => ['property' => 'og:language_ru', 'content' => '/ru'],
    'og_language_en' => ['property' => 'og:language_ru', 'content' => '/en'],
    'og_image' => ['property' => 'og:image', 'content' => Yii::$app->request->hostInfo . '/backend/web/uploads/'],
    'og_width' => ['property' => 'og:image:width', 'content' => 1280],
    'og_height' => ['property' => 'og:image:height', 'content' => 1280],
];
