<?php
namespace module\customer\widgets\home;

class Story extends \yii\base\Widget 
{
    public function run() 
    {
        $items = \WS::getStaticData('home.stories');
        
        return $this->render('story.phtml', ['items'=>$items]);
    }
}