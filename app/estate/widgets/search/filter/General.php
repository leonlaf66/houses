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
        if (isset($_GET['custom-price'])) {
            $_GET['price'] = $_GET['custom-price'];
        }

        if (isset($_GET['custom-square'])) {
            $_GET['square'] = $_GET['custom-square'];
        }

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
        if ($ruleId === 'price' && isset($_GET['custom-price'])) {
            return '';
        }
        if ($ruleId === 'square' && isset($_GET['custom-square'])) {
            return '';
        }

        if ($ruleId === 'property') {
            $values = $this->parseMultipleValues($ruleId);
            return in_array($value, $values) ? $className : '';
        }

        return WS::$app->request->get($ruleId) === $value ? $className : '';
    }

    public function parseRangeValues($field, $s = '~')
    {
        $items = explode($s, WS::$app->request->get($field));
        if ($customFieldValue = WS::$app->request->get('custom-'.$field)) {
            $items = explode($s, $customFieldValue);
        }
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
        if ($name === 'property') { // 多选支持
            return $this->createMultipleUrl($name, $value);
        }

        return SearchUrl::to($name, $value);
    }

    public function createMultipleUrl($name, $value)
    {
        if (! $value) {
            return SearchUrl::to($name, null);
        }

        $values = $this->parseMultipleValues($name);
        if (count($values) === 1 && $values[0] === $value) {
            return SearchUrl::to($name, null);
        }

        if (! in_array($value, $values)) {
            $values[] = $value;
        } else {
            $finedKey = array_search($value, $values);
            if ($finedKey !== false) {
                array_splice($values, $finedKey, 1);
            }
        }

        if (count($values) === 0) {
            return SearchUrl::to($name, null);
        }

        return SearchUrl::to($name, implode('~', $values));
    }

    public function clearMultipleUrl($name, $value)
    {
        $values = $this->parseMultipleValues($name);
        
        $finedKey = array_search($value, $values);
        if (false !== $finedKey) {
            array_splice($values, $finedKey, 1);
        }

        if (count($values) === 0) {
            return SearchUrl::to($name, null);
        }

        return SearchUrl::to($name, implode('~', $values));
    }

    public function parseMultipleValues($name)
    {
        $values = isset($_GET[$name]) ? $_GET[$name] : null;
        if ($values) {
            $values = explode('~', $values);
        } else {
            $values = [];
        }
        return $values;
    }

    public function multipleIn($name, $id)
    {
        $values = $this->parseMultipleValues($name);
        return in_array($id, $values);
    }
}