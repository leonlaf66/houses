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

        $min = 5;
        $maxState = ['value' => 0, 'idx' => 0];
        $mTotal = 0;
        foreach ($items as $idx => $item) {
            $items[$idx]->width_value = floatval($item->value);

            $value = floatval($item->value);
            if ($value < $min) {
                $items[$idx]->width_value = $min;
                $mTotal += $min - $value;
            } elseif ($value > $maxState['value']) {
                $maxState['value'] = $value;
                $maxState['idx'] = $idx;
            }
        }

        if ($mTotal > 0) {
            $items[$maxState['idx']]->width_value = $items[$maxState['idx']]->width_value - $mTotal;
        }

        $colors = ['#fac68d', '#aee9be', '#a3c9fb', '#99bd2a', '#f66c6c'];
        $idx = 0;
        $items = array_map(function ($item) use (& $idx, $colors) {
            $item->width_value = $item->width_value . '%';
            $item->height = $idx === 0 ? '24px' : '20px';
            $item->bgColor = $colors[$idx] ?? '#f66c6c';
            $idx ++;
            return $item;
        }, $items);

        return $items;
    }

    public function k12($schools)
    {
        return [count($schools->high), count($schools->middle), count($schools->grade)];
    }
}