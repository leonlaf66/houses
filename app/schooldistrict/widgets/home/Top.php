<?php
namespace module\schooldistrict\widgets\home;

class Top extends \yii\base\Widget
{
    public function run()
    {  
        $groups = \WS::getStaticData('home.schooldistrict.top');

        return $this->render('top.phtml', [
            'groups'=>$groups,
            'imageRoot'=>media_url('school-area/home-top/')
        ]);  
    }
}