<?php
namespace module\estate\widgets\search\filter;

use WS;
use yii\helpers\Url;
use module\estate\helpers\SearchUrl;

class SchoolDistrict extends \yii\base\Widget
{  
    public function run()
    {
        $items = \WS::$app->cache->get('estate.search.school-district.items');
        if (!$items) {
            $items = $this->getItems();
            \WS::$app->cache->set('estate.search.school-district.items', $items);
        }

        return $this->render('school-district.phtml', [
            'self'=>$this,
            'items'=>$this->getItems()
        ]);
    }

    public function isCurrent($value)
    {
        return WS::$app->request->get('school-district', '') === strtolower($value);
    }

    public function createUrl ($val)
    {
        $val = strtolower($val);
        $property = WS::$app->share('rets.property');
        $tab = WS::$app->share('rets.tab');
        if ($tab === 'search') {
            $tab = '';
        } else {
            $tab = '/'.$tab;
        }

        return SearchUrl::to('school-district', $val);
    }

    public function getItems()
    {
        return array_map(function ($item) {
            $code = $item->code;
            if (strpos($code, '/') !== false) {
                $code = str_replace('/', '|', $code);
            }

            $name = $item->name;
            foreach (['联合学区', '学区'] as $xq) {
                if (strpos($name, $xq)) {
                    $name = str_replace($xq, '', $name);
                }
            }

            return [$code, $name];
        }, \models\SchoolDistrict::xFind()->all());
    }
}