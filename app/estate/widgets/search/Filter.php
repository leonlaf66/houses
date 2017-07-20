<?php
namespace module\estate\widgets\search;

use WS;
use yii\helpers\Url;

class Filter extends \yii\base\Widget 
{  
    public $search = null;

    public function run()
    {  
    	$search = $this->search;

        return $this->render('filter.phtml', [
            'search'=>$search,
            'filters'=>[]
        ]);
    }

    public function tabs()
    {
        return [
            'search'=>'搜索',
            'school-districtss'=>'学区',
            'subway'=>'地铁'
        ];
    }

    public function createUrl($action = 'search')
    {
        $property = WS::$app->share('rets.property');
        if ($action === 'search') {
            return "/house/$property/";
        } else {
            return "/house/$property/{$action}/";
        }
    }

    public function isActivedTab($id)
    {
        $viewTypeId = \WS::$app->share('rets.tab');
        if (!in_array($viewTypeId, array_keys($this->tabs()))) {
            $viewTypeId = 'search';
        }

        return $viewTypeId === (string)$id;
    }

    public function getProperty()
    {
        return WS::$app->share('rets.property');
    }
}