<?php
namespace module\estate\widgets\search;

use WS;
use yii\helpers\Url;

class Filter extends \yii\base\Widget 
{
    public function run()
    {
        return $this->render('filter.phtml', [
            'filters'=>[]
        ]);
    }

    public function tabs()
    {
        $tabs = [
            'search'=>t('rets-filter', 'SEARCH'),
            'school-district'=>t('rets-filter', 'SCHOOL DISTRICTS'),
            'subway'=>t('rets-filter', 'SUBWAY')
        ];
        if ($this->getProperty() === 'lease') {
            unset($tabs['school-district']);
        }

        return $tabs;
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