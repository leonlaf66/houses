<?php
namespace module\customer\widgets\home;

class Story extends \yii\base\Widget 
{
    public function run() 
    {
        $items = \WS::getStaticData('home.stories.ma');
        
        return $this->render('story.phtml', ['items'=>$items]);
    }
}