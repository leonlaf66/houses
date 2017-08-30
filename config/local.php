<?php
return [
	'loginUrl' => 'http://passport.usleju.local/login/',
    'logoutUrl' => 'http://passport.usleju.local/logout/',
    'memberUrl' => 'http://member.usleju.local/',
    'components' => [
        'urlManager' => [
            'languageCookieOptions' => [
                'domain' => '.usleju.local'
            ]
        ],
    ]
];