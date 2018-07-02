<?php
namespace module\catalog\controllers;

use WS;
use yii\web\Controller;

class SitemapController extends Controller
{
    public function actionIndex()
    {
        WS::$app->page->metas = ['title' => tt('Sitemap', '网站地图')];
        $this->layout = '@module/page/views/layouts/main2.phtml';

        return $this->render('index.phtml');
    }
}
