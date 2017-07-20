<?php
return [
	'urlRules' => [
        'pro-service/'  => 'yellowpage/default/index',
        'pro-service/search/' => 'yellowpage/search/result',
        'pro-service/<id:\d+>/' => 'yellowpage/default/view'
	]
];