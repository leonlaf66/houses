<?php
namespace module\schooldistrict\widgets;

use WS;

class HouseList extends \yii\base\Widget
{
    public $schoolDistrict = null;

    public function run()
    {
        $towns = explode('/', $this->schoolDistrict->code);

        $items = \common\estate\RetsIndex::find()
            ->where(['in', 'town', $towns])
            ->andWhere(['=', 'prop_type', 'SF'])
            ->andWhere(['>', 'list_price', 700000])
            ->andWhere(['is_show' => true])
            ->orderBy(['id' => 'DESC'])
            ->limit(10)
            ->all();

        return $this->render('house-list.phtml', ['items'=>$items]);
    }
}