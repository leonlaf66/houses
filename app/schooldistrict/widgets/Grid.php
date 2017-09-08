<?php
namespace module\schooldistrict\widgets;

use WS;
use common\catalog\SchoolDistrict;

class Grid extends \yii\base\Widget
{
    public function run()
    {
        $items = WS::share('schooldistrict.items');
        return $this->render('grid.phtml', ['items'=>$items]);
    }

    public function k12($schools)
    {
        return [count($schools->high), count($schools->middle), count($schools->grade)];
    }
}