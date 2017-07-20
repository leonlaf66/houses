<?php
namespace module\estate\widgets\search\filter;

use WS;
use yii\helpers\Url;
use module\estate\helpers\Rets as RetsHelper;
use module\estate\helpers\SearchUrl;

class General extends \yii\base\Widget 
{  
    public $search = null;

    public function run()
    {  
        $search = $this->search;
        $filters = $this->getRules('generalFilters');
        foreach($filters as $filterId=>$filterOptions) {
            if (isset($_GET[$filterId]) && isset($filterOptions['apply'])) {
                ($filterOptions['apply'])($_GET[$filterId], $search);
            }
        }

        return $this->render('general.phtml', [
            'self'=>$this,
            'rules'=>$filters
        ]);
    }

    public function activeClass($ruleId, $value, $className = 'active')
    {
        return WS::$app->request->get($ruleId) === $value ? $className : '';
    }

    public function parseRangeValues($field, $s = '-')
    {
        $items = explode($s, WS::$app->request->get($field));
        if (count($items) === 0) $items = ['', '']; 
        if (count($items) === 1) $items[] = '';
        return $items;
    }

    public function getRules($scope)
    {
        $property = WS::$app->share('rets.property');
        $rules = RetsHelper::getSearchRules($property);
        return isset($rules[$scope]) ? $rules[$scope] :[];
    }

    public function createUrl($name, $value)
    {
        return SearchUrl::to($name, $value);
    }
}