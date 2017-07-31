<?php
$t = lang('rets-filters', true);
return [
    'generalFilters'=>[
        'price'=>[
            'heading'=>$t('Price'),
            'options'=>[
                ['~100000', '0 至 10万美元'],
                ['100000~300000', '10 至 30 万美元'],
                ['300000~600000', '30 至 60 万美元'],
                ['600000~1000000', '60 至 100 万美元'],
                ['1000000~', '100 万美元+']
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