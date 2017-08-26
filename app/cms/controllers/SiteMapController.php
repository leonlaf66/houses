<?php
namespace module\cms\controllers;

use WS;
use yii\web\Controller;

class SiteMapController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
