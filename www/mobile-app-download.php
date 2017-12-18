<?php
$downloads = [
    'android' => 'https://fir.im/e9gr?utm_source=fir&utm_medium=qr',
    'ios' => 'https://itunes.apple.com/us/app/%25E7%25B1%25B3%25E4%25B9%2590%25E5%25B1%2585/id1164743659?ls=1&mt=8'
];
$downloadTypeId = null;

$agent = strtolower($_SERVER['HTTP_USER_AGENT']);

//分析数据
$is_iphone = (false !== strpos($agent, 'iphone'));
$is_ipad = (false !== strpos($agent, 'ipad'));

if ($is_ipad || $is_iphone) {
    $downloadTypeId = 'ios';
}

$is_android = (false !== strpos($agent, 'android'));
if ($is_android) {
    $downloadTypeId = 'android';
}

if ($downloadTypeId) {
    header('Location: '.$downloads[$downloadTypeId]);
}