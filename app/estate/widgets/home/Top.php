<?php
namespace module\estate\widgets\home;

class Top extends \yii\base\Widget
{
    public function run()
    {
        $groups = \WS::getStaticData('home.rets.top');
        return $this->render('top.phtml', [
            'groups'=>$groups,
            'imageRoot'=>media_url('rets/home-top')
        ]);
    }
}