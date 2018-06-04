<?php
ini_set("display_errors","On");
error_reporting(E_ALL);

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

// define  root paths
defined('APP_ROOT') OR define('APP_ROOT', dirname(__DIR__));

ini_set('memory_limit', '1024M');

require(APP_ROOT . '/vendor/autoload.php');
require(APP_ROOT . '/vendor/yiisoft/yii2/Yii.php');

require(dirname(APP_ROOT) . '/fdn/WS.php');
require(APP_ROOT . '/app/App.php');

$config = require(APP_ROOT . '/config/main.php');

// 修正url末尾的'/'
if (substr($_SERVER['REQUEST_URI'], strlen($_SERVER['REQUEST_URI']) - 1, 1) !== '/') {
  $_SERVER['REQUEST_URI'] .= '/';
}

$app = new App($config);
$app->run();
