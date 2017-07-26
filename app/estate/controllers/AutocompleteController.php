<?php
namespace module\estate\controllers;

use WS;
use module\core\Controller;

class AutocompleteController extends Controller
{
    public function actionIndex()
    {
        $resultItems = [];

        $towns = \common\catalog\Town::find()->where([
            'state'=>\WS::$app->stateId
        ])->all();

        foreach ($towns as $town) {
            $resultItems[] = [
                'title' => $town->name,
                'desc' => $town->name_cn.',MA'
            ];
            
            if ($town->name_cn) {
                $resultItems[] = [
                    'title' => $town->name_cn,
                    'desc' => $town->name.',MA'
                ];
            }
        }

        $zipcodes = \common\catalog\Zipcode::find()->where([
            'state'=>\WS::$app->stateId
        ])->all();

        foreach ($zipcodes as $zipcode) {
            $resultItems[] = [
                'title' => $zipcode->zip,
                'desc' => $zipcode->city_name.','.$zipcode->city_name_cn.',MA'
            ];
        }

        return $this->ajaxJson($resultItems);
    }
}
