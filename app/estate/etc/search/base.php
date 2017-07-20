<?php
return [
    'generalFilters'=>[
        'square'=>[
            'heading'=>'面积',
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
            'heading'=>'卧室数',
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
            'heading'=>'卫生间',
            'options'=>[
                [null, '不限'],
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
            'heading'=>'车位',
            'options'=>[
                [null, '不限'],
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
            'heading'=>'车库',
            'options'=>[
                [null, '不限'],
                ['1', '有'],
                ['0', '无']
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
            'heading'=>'上市天数',
            'options'=>[
                [null, '不限'],
                ['1', '最新'],
                ['2', '本周'],
                ['3', '本月'],
                ['4', '本周之前'],
                ['5', '本月之前']
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