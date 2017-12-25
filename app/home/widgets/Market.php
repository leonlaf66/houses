<?php
namespace module\home\widgets;

class Market extends \yii\base\Widget
{
    public function run()
    {  
        $market = [
            'height'=>312,
            'backgroundImageUrl'=>'/static/img/banners/home-md.jpg',
            'title'=>'HOUSING MARKET OF MASSACHUSETTS'
        ];

        $marketings = $this->getMarketingValues();

        return $this->render('market.phtml', [
            'market'=>$market,
            'marketings' => $marketings
        ]);
    }

    public function getMarketingValues()
    {
        $maps = [
            'marketing/average-housing-price' => 1,
            'marketing/month-on-month-change' => 2,
            'marketing/prop-transactions-of-last-month' => 3,
            'marketing/new-listings-of-this-month' => 4
        ];
        
        $marketings = \models\SiteChartSetting::findData('ma', array_keys($maps));

        return array_key_value($marketings, function ($d, $path) use (& $maps) {
            $numKey = $maps[$path];
            return [
                $numKey, $d
            ];
        });
    }
}