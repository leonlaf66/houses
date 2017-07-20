<?php
namespace module\yellowpage\models;

class YellowPage extends \common\yellowpage\YellowPage
{
    public static function getOrderItems($key=null)
    {
        $list = \WS::$app->getModule('yellowpage')->getConfigs('yellowpage.order.items');
        if(is_null($key)) return $list;

        return isset($list[$key]) ? $list[$key] : null;
    }

    public function afterFind()
    {
        if(\WS::$app->language == 'zh-CN' && strlen($this->business_cn) > 0) {
            $this->business = $this->business_cn;
        }
        return parent::afterFind();
    }
}