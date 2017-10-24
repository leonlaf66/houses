<?php
namespace module\estate\helpers;

use WS;

class SearchAutocomplete
{
    public static function map()
    {
        $items = WS::$app->cache->get('estate.autocomplete.items', []);
        if (empty($items)) {
            $towns = \models\Town::find()
                ->where(['in', 'state', \WS::$app->area->stateIds])->all();

            foreach ($towns as $town) {
                $items[] = [
                    'title' => $town->name,
                    'desc' => $town->name_cn.',MA'
                ];
                
                if ($town->name_cn) {
                    $items[] = [
                        'title' => $town->name_cn,
                        'desc' => $town->name.',MA'
                    ];
                }
            }

            $zipcodes = \models\ZipcodeTown::find()
                ->where(['in', 'state', \WS::$app->area->stateIds])
                ->all();

            foreach ($zipcodes as $zipcode) {
                $items[] = [
                    'title' => $zipcode->zip,
                    'desc' => $zipcode->city_name.','.$zipcode->city_name_cn.',MA'
                ];
            }

            WS::$app->cache->set('estate.autocomplete.items', $items);
        }

        return $items;
    }
}