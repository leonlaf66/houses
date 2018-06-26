<?php
namespace module\page\widgets;

class FooterBefore extends \yii\base\Widget
{
    public function run()
    {
        return $this->render('html/footer-before.phtml');
    }

    public function getAreas()
    {
      return [
        'ma' => tt('Boston', '波士顿'),
        'ny' => tt('New York', '纽约'),
        'ga' => tt('Atlanta', '亚特兰大'),
        'ca' => tt('Los Angel', '洛杉矶'),
        'il' => tt('Chicago', '芝加哥')
      ];
    }
}