<?php
namespace module\estate\controllers;

use WS;
use module\core\Controller;
use module\estate\helpers;

class MapController extends Controller
{
    public $layout = '@module/page/views/layouts/main2_nofooter.phtml';
    
    public function actionIndex($type = 'purchase')
    {
        return $this->render('index.phtml', [
            'type' => $type,
            'dicts' => [
                'filterRules' => helpers\MapSearch::filterRules()[$type],
                'schools' => \models\SchoolDistrict::dictOptions(),
                'subwaies' => \models\SubwayStation::dictOptions(),
            ],
            'searchAutocompleteItems' => helpers\SearchAutocomplete::map()
        ]);
    }

    public function actionSearch($type = 'purchase')
    {
        $req = \Yii::$app->request;

        $search = \common\estate\HouseIndex::search();
        $search->query
            ->andFilterWhere([$type === 'lease' ? '=' : '<>', 'prop_type', 'RN'])
            ->andFilterWhere(['=', 'is_show', true]);

        $locationResult = helpers\MapSearch::applySearchLocation($search, $req->post('mode_val', null), $req->post('mode', 'areas'));
        helpers\MapSearch::applyFilters($search, $req->post('filters', []), helpers\MapSearch::filterRules()[$type]);

        if ($locationResult[1] === '') {
            return $this->ajaxJson([
                'city' => null,
                'cityPolygons' => [],
                'items' => []
            ]);
        }

        // 获取城市边界
        $cityPolygons = [];
        $cityName = null;
        if (is_array($locationResult) && count($locationResult) === 2) {
            list($cityCodes, $cityName) = $locationResult;
            foreach ($cityCodes as $cityCode) {
                $mapCityId = strtolower(\models\Town::getMapValue($cityCode, 'name_en'));
                $cityPolygons = array_merge($cityPolygons, \common\estate\helpers\Config::get('map.city.polygon/'.$mapCityId, []));
            }
        }

        $propTypeCodeIds = \common\estate\Rets::propertyTypeOptions();
        $items = array_map(function ($item) use($propTypeCodeIds) {
            $rets = $item->entity();
            return implode('|', [
                $item->id,
                $item->latitude,
                $item->longitude,
                floatval($item->list_price) / 10000,
                $rets->propId()
            ]);
        }, $search->query->all());

        return $this->ajaxJson([
            'type' => $type,
            'city' => $cityName,
            'cityPolygons' => $cityPolygons,
            'items' => $items,
        ]);
    }

    public function actionDetail($id)
    {
        $rets = \common\estate\Rets::findOne($id);
        $retsRender = $rets->render();

        return $this->ajaxJson([
            'id'=>$id,
            'image_url' => $rets->getPhoto(0, 500, 500),
            'name' => $retsRender->get('title'),
            'location' => $retsRender->get('location'),
            'list_price' => $retsRender->get('list_price'),
            'status_name' => $retsRender->get('status_name'),
            'no_bedrooms' => $retsRender->get('no_bedrooms', ['title'=>tt('Beds', '卧室数')]),
            'no_full_baths' => $retsRender->get('no_full_baths', ['title'=>tt('Full baths', '全卫')]),
            'no_half_baths' => $retsRender->get('no_half_baths', ['title'=>tt('Half baths', '半卫')]),
            'square_feet' => $retsRender->get('square_feet', ['title'=>tt('Living', '面积')]),
            'no_list_days' => $retsRender->get('no_list_days')
        ]);
    }
}