<?php
namespace module\yellowpage\widgets;

class CitySelector extends \yii\base\Widget 
{  
    public function run()
    {  
        $cities = \models\Town::getQueuedDefaultCitys();
        return $this->render('city-selector.phtml', [
            'cities'=>$cities
        ]);  
    }

    public function getCurrentCityName()
    {
        $currentCityId = isset($_GET['city']) ? intval($_GET['city']) : 0;
        if(! $currentCityId) return strtoupper(\WS::$app->area->id);

        $m = \models\Town::findOne($currentCityId);
        return $m->name ? $m->name : strtoupper(\WS::$app->area->id);
    }

    public function createUrl($args)
    {
        $args[0] = '/yellowpage/search/result';
        return \WS::$app->urlManager->createUrl($args);
    }

    public function resetUrl($args=[])
    {
        $args = array_merge($_GET, $args);

        foreach(['city', 'page'] as $var) {
            if(isset($args[$var])) {
                unset($args[$var]);
            }    
        }
        return $this->createUrl($args, false);
    }
}