<?php
namespace module\home\widgets;

use WS;

class TopBanner extends \yii\base\Widget
{  
    public function run()
    {  
        return $this->render('top-banner.phtml');  
    }

    public function getQueryText()
    {
        return \WS::$app->request->get('q', '');
    }

    public function totals()
    {
        $totals = \WS::$app->fetchCache('home.topbanner.totals');
        if (!$totals) {
            $totals = \module\estate\helpers\Summary::totals(\WS::$app->area->id);
            \WS::$app->saveCache('home.topbanner.totals', $totals);
        }

        return $totals;
    }
}