<?php
namespace module\home\controllers;

class DefaultController extends \yii\web\Controller
{
    public function actionIndex()
    {
        /*
        $rets = \common\estate\Rets::findOne('71779532');
        $priceValueHtml = $rets->render()->get('market_time_property');

        var_dump($priceValueHtml);
        exit;
        */

        return $this->render('index.phtml');
    }
}