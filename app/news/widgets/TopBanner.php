<?php
namespace module\news\widgets;

class TopBanner extends \yii\base\Widget
{
    public function run()
    {
        $result = include(APP_ROOT.'/config/news/top_banner.php');

        return $this->render('top-banners.phtml', [
            'result'=>$result
        ]);
    }
}