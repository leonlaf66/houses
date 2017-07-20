<?php
$propertyNames = \common\estate\Rets::propertyTypeNames();
unset($propertyNames['RN']);

$propTypes = [];
foreach($propertyNames as $name=>$lable) {
    if ($name !== 'RN') {
        $propTypes[] = [strtolower($name), $lable];
    }
}

return [
    'generalFilters'=>[
        'property'=>[
            'heading'=>'类型',
            'options'=>$propTypes,
            'apply'=>function ($val, $search) {
                $val = strtoupper($val);
                $search->query->andWhere(['=', 'prop_type', $val]);
            }
        ],
        'price'=>[
            'heading'=>'价格',
            'options'=>[
                ['~500000', '50万以下'],
                ['500000~800000', '50-80万'],
                ['800000~1200000', '80-120万'],
                ['2000000~', '200万以上']
            ],
            'apply'=>function ($val, $search) {
                list($begin, $end) = explode('~', $val);
                $begin = floatval($begin);
                $end = floatval($end);
                if ($end === 0.00) $end = 99999999999999.00;
                $search->query->andWhere(['>', 'list_price', $begin]);
                $search->query->andWhere(['<', 'list_price', $end]);
            }
        ],
        'square'=>[],
        'beds'=>[]
    ],
];