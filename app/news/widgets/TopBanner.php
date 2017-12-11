<?php
namespace module\news\widgets;

class TopBanner extends \yii\base\Widget
{
    public function run()
    {
        $result = \WS::getStaticData('news.banner.top.ma', []);

        return $this->render('top-banners.phtml', [
            'result'=>$result
        ]);
    }
}