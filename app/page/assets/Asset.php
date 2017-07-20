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
        '/static/lib/tipped-4.6.0-light/css/tipped/tipped.css',
        // 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css',
        '/static/css/jquery.typeahead.min.css',
        '/static/css/main.css'
    ];
    public $js = [
        '/static/lib/jquery.min.js',
        '/static/lib/tipped-4.6.0-light/js/tipped/tipped.js',
        // 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.full.min.js',
        '/static/js/jquery.typeahead.min.js',
        // 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/i18n/en.js',
        // 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/i18n/zh-CN.js',
        '/static/js/app.js?v1',
    ];
    public $depends = [
        
    ];
    public $jsOptions = ['position'=>\yii\web\View::POS_HEAD];
}
