<?php
namespace module\estate\helpers;

use WS;
use \yii\helpers\ArrayHelper as AH;

/**
 * 处理地图查询助手(pc网站专用)
 */
class MapSearch
{
    public static function applySearchLocation($search, $modeValue, $modeName)
    {
        $callName = 'apply'.ucfirst($modeName);
        return self::$callName($search, $modeValue);
    }
    public static function applyAreas($search, $q)
    {
        $townCode = '';
        $townName = '';

        $town = \common\catalog\Town::searchKeywords($q);
        if ($town) { // 城市
            $search->query->andWhere(['town' => $town->short_name]);

            $townCode = $town->short_name;
            $townName = $town->name;
        } else {
            $zipcode = \common\catalog\Zipcode::searchKeywords($q);
            if ($zipcode) { // zip
                $search->query->andWhere(['town' => $zipcode->city_short_name]);

                $townCode = $zipcode->city_short_name;
                $townName = $zipcode->city_name;
            }
        }

        // 应用条件
        if ($townCode) {
            $search->query->andFilterWhere(['=', 'town', $townCode]);
        } else {
            $search->query->andFilterWhere(['=', '1', '2']);
        }

        return [[$townCode], $townName];
    }

    public static function applySchools($search, $schoolId)
    {
        $code = \common\catalog\SchoolDistrict::findOne($schoolId)->code;
        $codes = explode('/', $code);
        $search->query->andFilterWhere(['in', 'town', $codes]);

        // 应用条件
        $townName = \common\catalog\Town::getMapValue($codes[0], 'name');

        return [$codes, $townName];
    }

    public static function applySubwaies($search, $subway)
    {
        $stationIds = $subway['stationIds'];
        $stationIdsExpr = '{'.implode(',', $stationIds).'}';
        $search->query->andFilterWhere(['&&', 'subway_stations', $stationIdsExpr]);

        return null;
    }

    public static function applyFilters($search, $filters, $filterRules)
    {
        $query = $search->query;

        foreach ($filters as $filterId => $val) {
            if (isset($filterRules[$filterId])) {
                $filterRule = $filterRules[$filterId];
                if (isset($filterRule['apply'])) {
                    ($filterRule['apply'])($search->query, $val, $filterRule);
                }
            }
        }
    }

    public static function filterRules()
    {
        $propertyTypes = \common\estate\Rets::propertyTypes();
        unset($propertyTypes['RN']);

        $rules['purchase'] = [
            'prop_type' => [
                'title' => tt('Type', '类型'),
                'options' => $propertyTypes,
                'apply' => function ($query, $vals) {
                    $query->andFilterWhere(['in', 'prop_type', $vals]);
                }
            ],
            'beds' => [
                'title' => tt('Bedroom', '卧室'),
                'options' => [
                    1 => '1+',
                    2 => '2+',
                    3 => '3+',
                    4 => '4+',
                    5 => '5+'
                ],
                'apply' => function ($query, $val) {
                    $query->andFilterWhere(['>', 'no_bedrooms', $val]);
                }
            ],
            'baths' => [
                'title' => tt('Bathroom', '卫生间'),
                'options' => [
                    1 => '1+',
                    2 => '2+',
                    3 => '3+',
                    4 => '4+',
                    5 => '5+'
                ],
                'apply' => function ($query, $val) {
                    $query->andFilterWhere(['>', 'no_bathrooms', $val]);
                }
            ],
            'parking' => [
                'title' => tt('Parking', '车位'),
                'options' => [
                    '1' => '1+',
                    '2' => '2+',
                    '3' => '3+'
                ],
                'apply' => function ($query, $val) {
                    $query->andFilterWhere(['>', 'parking_spaces', $val]);
                }
            ],
            'agrage' => [
                'title' => tt('Gerage', '车库'),
                'options' => [
                    1 => tt('Yes', '有'),
                    2 => tt('No', '无')
                ],
                'apply' => function ($query, $val) {
                    if ($val == 1) {
                        $query->andFilterWhere(['>', 'garage_spaces', 0]);
                    }
                }
            ],
            'market-days' => [
                'title' => tt('Days on market', '上市天数'),
                'options' => [
                    '1' => tt('New listing', '最新'),
                    '2' => tt('This week', '本周'),
                    '3' => tt('This month', '本月')
                ],
                'apply' => function ($query, $val) {
                    $getRangeFns = [
                        '1'=>function(){
                            $now = time();
                            return [$now - 86400 * 2, $now];
                        },
                        '2'=>function(){
                            $now = time();
                            return [$now - 86400 * 7, $now];
                        },
                        '3'=>function(){
                            $now = time();
                            return [$now - 86400 * 30, $now];
                        }
                    ];

                    if(isset($getRangeFns[$val])) {
                        $getRangeFn = $getRangeFns[$val];
                        list($start, $end) = $getRangeFn();
                        $start = date('Y-m-d', $start);
                        $end = date('Y-m-d', $end);
                        $query->andWhere('list_date>=:start and list_date <=:end', [
                            ':start'=>$start,
                            ':end'=>$end
                        ]);
                    }
                }
            ],
            'price' => [
                'title' => tt('Pirce', '价格'),
                'options' => [
                    '0~500000' => tt('0-500,000', '50万以下'),
                    '500000~1000000' => tt('500,000-1,000,000', '50-100万'),
                    '1000000~1500000' => tt('1,000,000-1,500,000', '100-150万'),
                    '1500000~2000000' => tt('1,500,000~2,000,000', '150-200万'),
                    '2000000~999999999999' => tt('2,000,000+', '200万以上')
                ],
                'custom' => [
                    'type' => 'range'
                ],
                'apply' => function ($query, $val) {
                    list($start, $end) = explode('~', $val);
                    $query->andFilterWhere(['>=', 'list_price', $start]);
                    $query->andFilterWhere(['<=', 'list_price', $end]);
                }
            ],
            'square' => [
                'title' => tt('Living area', '居住面积'),
                'options' => [
                    '0~1000' => tt('0-1000', '0-100'),
                    '1000~2000' => tt('1000-2000', '100-200'),
                    '2000~3000' => tt('2000-3000', '200-300'),
                    '3000~999999999999' => tt('3000+', '300+')
                ],
                'custom' => [
                    'type' => 'range'
                ],
                'apply' => function ($query, $val) {
                    list($start, $end) = explode('~', $val);
                    $query->andFilterWhere(['>=', 'square_feet', $start]);
                    $query->andFilterWhere(['<=', 'square_feet', $end]);
                }
            ],
        ];

        $rules['lease'] = [
            'beds' => [
                'title' => tt('Bedroom', '卧室'),
                'options' => [
                    1 => '1+',
                    2 => '2+',
                    3 => '3+',
                    4 => '4+',
                    5 => '5+'
                ],
                'apply' => function ($query, $val) {
                    $query->andFilterWhere(['>', 'no_bedrooms', $val]);
                }
            ],
            'baths' => [
                'title' => tt('Bathroom', '卫生间'),
                'options' => [
                    1 => '1+',
                    2 => '2+',
                    3 => '3+',
                    4 => '4+',
                    5 => '5+'
                ],
                'apply' => function ($query, $val) {
                    $query->andFilterWhere(['>', 'no_bathrooms', $val]);
                }
            ],
            'parking' => [
                'title' => tt('Parking', '车位'),
                'options' => [
                    '1' => '1+',
                    '2' => '2+',
                    '3' => '3+'
                ],
                'apply' => function ($query, $val) {
                    $query->andFilterWhere(['>', 'parking_spaces', $val]);
                }
            ],
            'price' => [
                'title' => tt('Price', '价格'),
                'options' => [
                    '0~1000' => '0-1,000',
                    '1000~1500' => '1,000-1,500',
                    '1500~2000' => '1,500-2,000',
                    '2000~99999999' => '2,000+'
                ],
                'custom' => [
                    'type' => 'range'
                ],
                'apply' => function ($query, $val) {
                    list($start, $end) = explode('~', $val);
                    $query->andFilterWhere(['>=', 'list_price', $start]);
                    $query->andFilterWhere(['<=', 'list_price', $end]);
                }
            ],
        ];

        return $rules;
    }
}