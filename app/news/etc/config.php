<?php
return [
    'urlRules' => [
        'news/channel<type:\d+>/'=>'news/default/index',
        'news/'  => 'news/default/index',
        'news/<id:\d+>/'=>'news/default/view',
        'news/pdf/'  => 'news/default/pdf',
    ]
];