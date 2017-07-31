<?php
$t = lang('rets-filters', true);
$tAll = tt('ALL', '不限');

return [
    'generalFilters'=>[
        'square'=>[
            'heading'=>$t('Living area'),
            'options'=>[
                ['~1000', '0-1000'],
                ['1000~2000', '1000 - 2000'],
                ['2000~3000', '2000-3000'],
                ['3000~', '3000+']
            ],
            'apply'=>function ($val, $search) {
                list($begin, $end) = explode('~', $val);
                $begin = floatval($begin);
                $end = floatval($end);
                if ($end === 0.00) $end = 99999999999999.00;
                $search->query->andWhere(['>', 'square_feet', $begin]);
                $search->query->andWhere(['<', 'square_feet', $end]);
            }
        ],
        'beds'=>[
            'heading'=>$t('Bedroom'),
            'options'=>[
                ['1', '1+'],
                ['2', '2+'],
                ['3', '3+'],
                ['4', '4+'],
                ['5', '5+']
            ],
            'apply'=>function ($val, $search) {
                $val = intval($val);
                $search->query->andWhere(['>=', 'no_bedrooms', $val]);
            }
        ]
    ],
    'dropdownFilters'=>[
        'baths'=>[
            'heading'=>tt('Bathroom', '卫生间'),
            'options'=>[
                [null, $tAll],
                ['1', '1+'],
                ['2', '2+'],
                ['3', '3+'],
                ['4', '4+'],
                ['5', '5+']
            ],
            'apply'=>function ($val, $search) {
                $val = intval($val);
                $search->query->andWhere(['>=', 'no_bathrooms', $val]);
            }
        ],
        'parking'=>[
            'heading'=>tt('Parking', '车位'),
            'options'=>[
                [null, $tAll],
                ['1', '1+'],
                ['2', '2+'],
                ['3', '3+'],
            ],
            'apply'=>function ($val, $search) {
                $val = intval($val);
                $search->query->andWhere(['>=', 'parking_spaces', $val]);
            }
        ],
        'agrage'=>[
            'heading'=>tt('Garage', '车库'),
            'options'=>[
                [null, $tAll],
                ['1', tt('Yes', '有')],
                ['0', tt('No', '无')]
            ],
            'apply'=>function ($val, $search) {
                $val = intval($val);
                if ($val === 1) {
                    $search->query->andWhere(['>', 'garage_spaces', 0]);
                } else {
                    $search->query->andWhere(['=', 'garage_spaces', 0]);
                }
            }
        ],
        'market-days'=>[
            'heading'=>tt('Days on market', '上市天数'),
            'options'=>[
                [null, $tAll],
                ['1', tt('New listing', '最新')],
                ['2', tt('This week', '本周')],
                ['3', tt('This month', '本月')]
            ],
            'apply'=>function ($value, $search) {
                if($value !== '') {
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

                    if(isset($getRangeFns[$value])) {
                        $getRangeFn = $getRangeFns[$value];
                        list($start, $end) = $getRangeFn();
                        $start = date('Y-m-d', $start);
                        $end = date('Y-m-d', $end);
                        $search->query->andWhere('list_date>=:start and list_date <=:end', [
                            ':start'=>$start,
                            ':end'=>$end
                        ]);
                    }
                }
            }
        ]
    ]
];