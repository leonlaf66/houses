<?php
$t = lang('rets-filters', true);
return [
    'generalFilters'=>[
        'price'=>[
            'heading'=>$t('Price'),
            'options'=>[
                ['~1000', '0-1000'],
                ['1000~1500', '1000-1500'],
                ['1500~2000', '1500-2000'],
                ['2000~', '2000+']
            ],
            'apply'=>function ($val, $search) {
                list($begin, $end) = explode('~', $val);
                $begin = floatval($begin);
                $end = floatval($end);
                if ($end === 0.00) $end = 99999999999999.00;
                $search->query->andWhere(['>', 'list_price', $begin]);
                $search->query->andWhere(['<', 'list_price', $end]);
            }
        ]
    ],
];