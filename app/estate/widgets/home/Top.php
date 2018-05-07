<?php
namespace module\estate\widgets\home;

class Top extends \yii\base\Widget
{
    public function run()
    {
        $items = \models\SiteSetting::get('home.luxury.houses', \WS::$app->area->id);
        $this->fillHouses($items);

        /*分列 以便更容易渲染输出*/
        $groups = [];
        $groupIndex = 0;
        $colTotal = 0;
        foreach ($items as $item) {
            list($colWidth, $cols) = explode('-', $item['col_rule']);
            $colWidth = intval($colWidth);
            $cols = intval($cols);

            if ($colTotal + $colWidth < $cols) { // 当前组内
                $groups[$groupIndex][] = (array)$item;
                $colTotal += $colWidth;
            } else { // 到达组内最后一个
                $groups[$groupIndex][] = (array)$item; // 实际是前一组的最后一个
                $colTotal = 0;
                $groupIndex ++;
            }
        }

        return $this->render('top.phtml', [
            'groups'=>$groups,
            'imageRoot'=>media_url('home-top')
        ]);
    }

    public function fillHouses(& $items)
    {
        $listNos = array_map(function ($d) {
            return $d['id'];
        }, $items);

        $houses = \WS::$app->houseApi->create('house/list-by-ids')
            ->setParams([
                'ids' => $listNos
            ])
            ->send()
            ->asData();

        $houses = \yii\helpers\ArrayHelper::index($houses, 'id');

        foreach ($items as $idx => $item) {
            $listNo = $item['id'];
            if (isset($houses[$listNo])) {
                $items[$idx]['house'] = $houses[$listNo];
            }
        }
    }
}