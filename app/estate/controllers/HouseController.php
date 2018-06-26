<?php
namespace module\estate\controllers;

use WS;
use yii\web\Controller;
use \module\cms\helpers\UrlParamEncoder;
use \module\estate\helpers\FieldFilter;

class HouseController extends Controller
{
    public function actionIndex($type = 'lease', $tab = 'search', $q='', $params='')
    {
        $req = WS::$app->request;
        WS::$app->share('rets.property', $type);
        WS::$app->share('rets.tab', $tab);

        if ($type === 'purchase' && empty($q)) { // 默认为前三种房源类型，能过cookie做状态切换
            if ($params === '') {
                if (! \WS::$app->request->cookies->getValue('def-sell-type-flag', false)) {
                    if ($tab === 'search') {
                        $q = '';
                        if (isset($_GET['q'])) $q = '?q='.$_GET['q'];
                        return $this->redirect('/house/purchase/pt-sf2mf2cc/'.$q);
                    }
                    return $this->redirect('/house/purchase/'.$tab.'/pt-sf2mf2cc/');
                }
            } elseif ($params !== 'pt-sf2mf2cc') { // 写cookie状态
                \WS::$app->response->cookies->add(new \yii\web\Cookie([
                    'name' => 'def-sell-type-flag',
                    'value' => 1,
                    'expire' => time() + 3600, // 8 小时
                    'domain' => domain()
                ]));
            }
        }

        // url编码参数映射
        UrlParamEncoder::setup($params, [
            'q'=>'q',
            'school-district'=>'sd',
            'subway-line'=>'sl',
            'subway-stations'=>'ss',
            'property'=>'pt',
            'price'=>'pr',
            'square'=>'sq',
            'beds'=>'bd',
            'baths'=>'ba',
            'parking'=>'pa',
            'agrage'=>'ag',
            'market-days'=>'md',
            'sort'=>'st',
            'page'=>'p'
        ]);

        $params = [
            'type' => $type,
            'q' => $q,
            'page' => $req->get('page', 1),
            'filters' => [],
            'sort' => $req->get('sort', 0)
        ];

        $filterKeys = 'school-district,subway-line,subway-stations,property,price,square,beds,baths,parking,agrage,market-days,cp,cs';
        $filterMaps = [
            'school-district' => function ($townCode) {
                $townCode = strtoupper($townCode);
                $townCode = explode('|', $townCode);
                $cityId = (new \yii\db\Query())
                    ->select('id')
                    ->from('town')
                    ->where(['in', 'short_name', $townCode])
                    ->column();
                if (count($cityId) === 1) $cityId = $cityId[0];

                return [
                    'city-id',
                    $cityId
                ];
            },
            'subway-stations' => function ($vals) {
                return ['subway-stations', explode('a', $vals)];
            },
            'property' => function ($codes) {
                $codes = explode('2', $codes);
                return ['prop', $codes];
            },
            'cp' => function ($range) use ($type) {
                $range = explode('-', $range);
                $range = array_map(function ($d) use ($type) {
                    return intval($d) * (\WS::$app->language === 'zh-CN' && $type === 'purchase' ? 10000 : 1);
                }, $range);

                return ['price', $range];
            },
            'cs' => function ($range) {
                $range = explode('-', $range);
                $range = array_map(function ($d) {
                    return intval($d) * (\WS::$app->language === 'zh-CN' ? 0.092903 : 1);
                }, $range);
                return ['square', $range];
            }
        ];
        foreach (explode(',', $filterKeys) as $filterKey) {
            if ($filterValue = $req->get($filterKey)) { // 需要参数变换
                if (isset($filterMaps[$filterKey])) {
                    if (is_string($filterMaps[$filterKey])) {
                        $filterKey = $filterMaps[$filterKey];
                    } elseif (get_class($filterMaps[$filterKey]) === 'Closure') {
                        if ($mapResult = ($filterMaps[$filterKey])($filterValue)) {
                            list($filterKey, $filterValue) = $mapResult;
                        }
                    }
                }

                $params['filters'][$filterKey] = $filterValue;
            }
        }

        //排序处理
        if (isset($params['sort']) && $params['sort'] < 5) {
            $sorts = [
                ['ldays', 'desc'],
                ['price', 'asc'],
                ['price', 'desc'],
                ['beds', 'desc'],
                ['beds', 'asc']
            ];
            $params['sort'] = $sorts[$params['sort']];
        }

        // api 数据请求
        $results = \WS::$app->houseApi->create("house/search")
            ->setParams($params)
            ->send()
            ->asData();

        WS::$app->page->setId('estate/house/'.$type);

        return $this->render('index.phtml', [
            'tab'=>$tab,
            'type'=>$type,
            'results'=>$results
        ]);
    }

    public function actionView($type = 'lease', $id = null)
    {
        $fields = 'id,nm,loc,prop,img_cnt,price,est_sale,sub_tnm,beds,baths,area,square,lot_size,latlng,polygons,roi,details,recommends,taxes,mls_id,area_id,tour,liked';

        $houseData = \WS::$app->houseApi->create("house/{$id}")
            ->setParams([
                'fields' => $fields,
                'recommends_options' => [
                    'limit' => 4
                ]
            ])
            ->send()
            ->asData();

        WS::$app->page->setId('estate/house/'.$type.'/view');

        // seo参数
        WS::$app->page->bindParams($this->getHouseSeoParams($houseData));

        return $this->render("view.phtml", [
            'type'=>$type,
            'data'=>$houseData
        ]);
    }

    private function getHouseSeoParams($data)
    {
        $cityName2propName = explode(',', $data['nm'])[0];
        $roomsName = explode(',', $data['nm'])[1];
        $propName = FieldFilter::housePropName($data['prop']);

        $squareField = $data['prop'] === 'LD' ? 'lot_size' : 'square';
        $square = FieldFilter::square($data[$squareField]);
        if (is_array($square)) {
            $square = implode('', $square);
        } else {
            $square = '';
        }

        $params = [
            'name' => $data['nm'],
            'city' => str_replace($propName, '', $cityName2propName),
            'property' => $propName,
            'price' => implode('', FieldFilter::money($data['price'])),
            'rooms' => $roomsName,
            'square' => $square,
            'location' => $data['loc']
        ];

        if ($data['prop'] === 'RN') {
            foreach ($data['details'] as $group) {
                foreach ($group['items'] as $field => $item) {
                    if ($field === 'appliances') {
                        $params['appliances'] = $item['value'];
                        break;
                    }
                }
                if (isset($params['appliances'])) {
                    break;
                }
            }
        }

        return $params;
    }
}