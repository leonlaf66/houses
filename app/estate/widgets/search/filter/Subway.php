<?php
namespace module\estate\widgets\search\filter;

use WS;
use yii\helpers\Url;
use module\estate\helpers\SearchUrl;

class Subway extends \yii\base\Widget 
{  
    public $search = null;

    public function run()
    {  
        $search = $this->search;

        $stations = \module\catalog\models\SubwayStation::getAllStations();

        return $this->render('subway.phtml', [
            'self'=>$this,
            'stations'=>$stations,
            'current'=>[
                'line'=>$this->getCurrentSubwayLine(),
                'stations'=>WS::$app->request->get('stations', [])
            ]
        ]);
    }

    public function createLineUrl($value)
    {
        return SearchUrl::replaceTo('subway-line', $value);
    }

    public function createStationUrl($value = null)
    {
        $values = $this->parseValues();
        
        if ($value) {
            if (!in_array($value, $values)) {
                $values[] = $value;
            }
        } else {
            if ($key = array_search($value, $values)) {

            }
        }

        return SearchUrl::to('subway-stations', implode('a', $values));
    }

    public function clearStationUrl($value)
    {
        $values = $this->parseValues();
        
        $finedKey = array_search($value, $values);
        if (false !== $finedKey) {
            array_splice($values, $finedKey, 1);
        }

        if (count($values) === 0) {
            return SearchUrl::to('subway-stations', null);
        }

        return SearchUrl::to('subway-stations', implode('a', $values));
    }

    public function parseValues()
    {
        $values = isset($_GET['subway-stations']) ? $_GET['subway-stations'] : null;
        if ($values) {
            $values = explode('a', $values);
        } else {
            $values = [];
        }
        return $values;
    }

    public function stationIn($id)
    {
        $values = $this->parseValues();
        return in_array($id, $values);
    }

    public function getCurrentSubwayLine()
    {
        $subwayLine = isset($_GET['subway-line']) ? intval($_GET['subway-line']) : 1;
        return $subwayLine;
    }
}