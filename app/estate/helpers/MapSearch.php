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
        if (is_numeric($q) && strlen(trim($q)) !== 5) { // mlsid
            $search->query->andFilterWhere(['=', 'id', $q]);
            return -1; // 城市单独从结果中获取
        }

        // 是城市名和邮编
        $townName = \common\catalog\Town::getMapValue($q, 'name');
        $townCode = \common\catalog\Town::getMapValue($q, 'short_name');

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
                'title' => '类型',
                'options' => $propertyTypes,
                'apply' => function ($query, $vals) {
                    $query->andFilterWhere(['in', 'prop_type', $vals]);
                }
            ],
            'beds' => [
                'title' => '卧室',
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
                'title' => '卫生间',
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
                'title' => '车位',
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
                'title' => '车库',
                'options' => [
                    1 => '有',
                    2 => '无'
                ],
                'apply' => function ($query, $val) {
                    if ($val == 1) {
                        $query->andFilterWhere(['>', 'garage_spaces', 0]);
                    }
                }
            ],
            'market-days' => [
                'title' => '上市天数',
                'options' => [
                    '1' => '最新',
                    '2' => '本周',
                    '3' => '本月',
                    '4' => '本周之前',
                    '5' => '本月之前'
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
                        },
                        '4'=>function(){
                            $now = time();
                            return [0, $now - 86400 * 7];
                        },
                        '5'=>function(){
                            $now = time();
                            return [0, $now - 86400 * 30];
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
                'title' => '价格',
                'options' => [
                    '0~500000' => '50万以下',
                    '500000~800000' => '50-80万',
                    '800000~1200000' => '80-120万',
                    '2000000~9999999999' => '200万以上'
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
                'title' => '面积',
                'options' => [
                    '0~1000' => '0-1000',
                    '1000~2000' => '1000 - 2000',
                    '2000~3000' => '2000-3000',
                    '3000~999999999999' => '3000+'
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
                'title' => '卧室',
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
                'title' => '卫生间',
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
                'title' => '车位',
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
                'title' => '价格',
                'options' => [
                    '0~1000' => '- 1,000',
                    '1000~1500' => '1,000 - 1,500',
                    '1500~2000' => '1,500 - 2,000',
                    '2000~2500' => '2,000 - 2,500',
                    '2500~99999999' => '2,500 +'
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