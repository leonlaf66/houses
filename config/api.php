<?php
return [
    'components' => [
        'houseApi' => [
            'class' => 'module\core\components\api\Client',
            'baseUrl' => 'http://127.0.0.1:8001',
            'requestConfig' => [
                'class' => 'module\core\components\api\Request',
                'headers' => [
                    'content-type' => 'application/json',
                    'user-agent' => 'Usleju website'
                ],
                'apiToken' => '',
                'format' => 'json'
            ],
            'responseConfig' => [
                'class' => 'module\core\components\api\Response',
                'format' => 'json'
            ],
        ]
    ]
];
