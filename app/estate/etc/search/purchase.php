<?php
$propertyNames = \common\estate\Rets::propertyTypeNames();
unset($propertyNames['RN']);

$propTypes = [];
foreach($propertyNames as $name=>$lable) {
    if ($name !== 'RN') {
        $propTypes[] = [strtolower($name), $lable];
    }
}

$t = lang('rets-filters', true);
return [
    'generalFilters'=>[
        'property'=>[
            'heading'=>$t('Type'),
            'options'=>$propTypes,
            'apply'=>function ($val, $search) {
                $propTypes = explode('~', strtoupper($val));
                $search->query->andWhere(['in', 'prop_type', $propTypes]);
            }
        ],
        'price'=>[
            'heading'=>$t('Price'),
            'options'=>[
                ['~500000', tt('0-500,000', '0-50万')],
                ['500000~1000000', tt('500,000-1,000,000', '50-100万')],
                ['1000000~1500000', tt('1,000,000-1,500,000', '100-150万')],
                ['1500000~2000000', tt('1,500,000-2,000,000', '150-200万')],
                ['2000000~', tt('2,000,000', '200万+')]
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