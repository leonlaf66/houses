<?php
namespace module\estate\controllers;

use WS;
use yii\web\Controller;

class AutocompleteController extends Controller
{
    public function actionIndex()
    {
        $result = [];

        $cities = $this->_getEtcData('cities');
        foreach($cities as $key=>$value) {
            $result[] = [
                'name'=>$value, 
                'type'=>'City'
            ];
        }

        $dictData = $this->_getEtcData('zip');
        foreach($dictData['zip_code'] as $zip=>$options) {
            $result[] = [
                'name'=>''.$zip, 
                'type'=>$options['city'].' [Zip Code]'
            ];
        }

        echo json_encode([
                'cities'=>$result
            ]
        );
    }

    protected function _getEtcData($name)
    {
        return include(COMMON_ROOT.'/estate/config/dicts/'.$name.'.php');
    }
}
