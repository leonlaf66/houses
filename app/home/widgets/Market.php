<?php
namespace module\home\widgets;

class Market extends \yii\base\Widget
{
    public function run()
    {
        $markets = [
            'ma' => [
                'height'=>312,
                'backgroundImageUrl'=>'/static/img/banners/home-md.jpg',
                'title'=>tt('HOUSING MARKET OF MASSACHUSETTS', '麻州房市走势')
            ],
            'ny' => [
                'height'=>312,
                'backgroundImageUrl'=>'/static/img/banners/home-md.jpg',
                'title'=>tt('HOUSING MARKET OF NEW YORK', '纽约房市走势')
            ],
            'ga' => [
                'height'=>312,
                'backgroundImageUrl'=>'/static/img/banners/home-md.jpg',
                'title'=>tt('HOUSING MARKET OF GEORGIA', '亚特兰大房市走势')
            ],
            'il' => [
                'height'=>312,
                'backgroundImageUrl'=>'/static/img/banners/home-md.jpg',
                'title'=>tt('HOUSING MARKET OF ILLINOIS', '芝加哥房市走势')
            ],
            'ca' => [
                'height'=>312,
                'backgroundImageUrl'=>'/static/img/banners/home-md.jpg',
                'title'=>tt('HOUSING MARKET OF DISTRICT OF COLOMBIA', '洛杉矶房市走势')
            ],
        ];

        $marketings = $this->getMarketingValues();

        return $this->render('market.phtml', [
            'market'=>$markets[\WS::$app->area->id],
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
        
        $marketings = \models\SiteChartSetting::findData(\WS::$app->area->id, array_keys($maps));

        return array_key_value($marketings, function ($d, $path) use (& $maps) {
            $numKey = $maps[$path];
            return [
                $numKey, $d
            ];
        });
    }
}