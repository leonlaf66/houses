<?php
namespace module\estate\helpers;

use WS;
use \yii\helpers\ArrayHelper as AH;
use module\cms\helpers\UrlParamEncoder;

class SearchUrl
{
    public static function to($key, $value)
    {
        list($property, $tab) = self::getBaseInfo();
        $newUrlParamValue = UrlParamEncoder::$inst->setParam($key, $value);
        if ($newUrlParamValue === '') {
            return \yii\helpers\Url::to('/house/'.$property.$tab.'/');
        }
        return \yii\helpers\Url::to('/house/'.$property.$tab.'/'.$newUrlParamValue.'/');
    }

    public static function replaceTo($key, $value)
    {
        list($property, $tab) = self::getBaseInfo();
        $newUrlParamValue = UrlParamEncoder::$inst->setParam($key, $value, true);
        if ($newUrlParamValue === '') {
            return \yii\helpers\Url::to('/house/'.$property.$tab.'/');
        }
        return \yii\helpers\Url::to('/house/'.$property.$tab.'/'.$newUrlParamValue.'/');
    }

    public static function getBaseInfo()
    {
        $property = WS::$app->share('rets.property');
        $tab = WS::$app->share('rets.tab');
        if ($tab === 'search') {
            $tab = '';
        } else {
            $tab = '/'.$tab;
        }

        return [$property, $tab];
    }
}