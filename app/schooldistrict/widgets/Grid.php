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

    public function racials($items)
    {
        if (! is_array($items)) {
            $items = [];
        }

        $colors = ['#fac68d', '#aee9be', '#a3c9fb', '#99bd2a', '#f66c6c'];
        $idx = 0;
        return array_map(function ($item) use (& $idx, $colors) {
            $item->height = $idx === 0 ? '24px' : '20px';
            $item->bgColor = $colors[$idx] ?? '#f66c6c';
            $idx ++;
            return $item;
        }, $items);
    }

    public function k12($schools)
    {
        return [count($schools->high), count($schools->middle), count($schools->grade)];
    }
}