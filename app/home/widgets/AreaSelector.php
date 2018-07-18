<?php
namespace module\home\widgets;

class AreaSelector extends \yii\base\Widget
{
    public function run()
    {
        return $this->render('area-selector.phtml');
    }
}