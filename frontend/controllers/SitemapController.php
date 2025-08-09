<?php
namespace frontend\controllers;
 
// use frontend\models\Blog\Categories;
use yii\web\Controller;
use yii\db\Query;
use Yii;
// use backend\models\Subcategories;
class SitemapController extends Controller
{
 
    public function actionIndex()
    {
      // header('Content-type: application/xml');

 	date_default_timezone_set("Asia/Tashkent");
       $urls = [];
        // Выбираем категории сайта
        $urls[] = [
            'slug' => '/',
            'changefreq' => 'daily',
            'time'=>date('c', time())
        ];
        
        
        
        
        // // Выбираем категории сайта
        $branches = \common\models\Product::find()->all();
        foreach ($branches as $row) {
            $urls[] = [
                'slug' => Yii::$app->urlManager->createUrl(['/item-'.$row->url]),           // создаем ссылки на выбранные категории
                'changefreq' => 'daily',                                                     // вероятная частота изменения категории
                'time'=>date('c', $row->created_date)
            ];
        }

        // // Выбираем категории сайта
        $branches = \common\models\Product::find()->all();
        foreach ($branches as $row) {
            $urls[] = [
                'slug' => Yii::$app->urlManager->createUrl(['/ru/item-'.$row->url_ru]),           // создаем ссылки на выбранные категории
                'changefreq' => 'daily',                                                     // вероятная частота изменения категории
                'time'=>date('c', $row->created_date)
            ];
        }

        // // Выбираем категории сайта
        $branches = \common\models\Product::find()->all();
        foreach ($branches as $row) {
            $urls[] = [
                'slug' => Yii::$app->urlManager->createUrl(['/en/item-'.$row->url_en]),           // создаем ссылки на выбранные категории
                'changefreq' => 'daily',                                                     // вероятная частота изменения категории
                'time'=>date('c', $row->created_date)
            ];
        }

	    $shop = \common\models\Category::find()->all();
        foreach ($shop as $row) {
            $urls[] = [
                'slug' => Yii::$app->urlManager->createUrl(['/shop-'.$row->url]),           // создаем ссылки на выбранные категории
                'changefreq' => 'daily',                                                     // вероятная частота изменения категории
                'time'=>date('c', time())
            ];
        }

        $shop = \common\models\Category::find()->all();
        foreach ($shop as $row) {
            $urls[] = [
                'slug' => Yii::$app->urlManager->createUrl(['/ru/shop-'.$row->url_ru]),           // создаем ссылки на выбранные категории
                'changefreq' => 'daily',                                                     // вероятная частота изменения категории
                'time'=>date('c', time())
            ];
        }

        $shop = \common\models\Category::find()->all();
        foreach ($shop as $row) {
            $urls[] = [
                'slug' => Yii::$app->urlManager->createUrl(['/en/shop-'.$row->url_en]),           // создаем ссылки на выбранные категории
                'changefreq' => 'daily',                                                     // вероятная частота изменения категории
                'time'=>date('c', time())
            ];
        }

	    $blogs = \common\models\Post::find()->where(['status' => 1])->all();
        foreach ($blogs as $row) {
            $urls[] = [
                'slug' => Yii::$app->urlManager->createUrl(['/blog-view/'.$row->id]),           // создаем ссылки на выбранные категории
                'changefreq' => 'daily',                                                     // вероятная частота изменения категории
                'time'=>date('c', $row->created_date)
            ];
        }

	$blogCategory = \common\models\PostCategory::find()->all();
        foreach ($blogCategory as $row) {
            $urls[] = [
                'slug' => Yii::$app->urlManager->createUrl(['/blog-category/'.$row->id]),           // создаем ссылки на выбранные категории
                'changefreq' => 'daily',                                                     // вероятная частота изменения категории
                'time'=>date('c', $row->created_date)
            ];
        }
        
        $xml_sitemap = $this->renderPartial('index', [ // записываем view на переменную для последующего кэширования
            'host' => Yii::$app->request->hostInfo,         // текущий домен сайта
            'urls' => $urls,                                // с генерированные ссылки для sitemap
        ]);

        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $headers = Yii::$app->response->headers;
        $headers->add('Content-Type', 'text/xml');
    
        return $xml_sitemap;
    }
    
}