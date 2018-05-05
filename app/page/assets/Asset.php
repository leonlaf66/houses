<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace module\page\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Asset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'static/common/tipped-4.6.0-light/css/tipped/tipped.css',
        'static/css/jquery.typeahead.min.css',
        'static/css/main.css?v1.03'
    ];
    public $js = [
	    'static/common/lazyload.min.js',
        'static/common/tipped-4.6.0-light/js/tipped/tipped.js',
        'static/common/jquery.typeahead.min.js',
        'static/js/app.js'
    ];
    public $depends = ['\yii\web\JqueryAsset'];

    public $jsOptions = ['position'=>\yii\web\View::POS_HEAD];
}
