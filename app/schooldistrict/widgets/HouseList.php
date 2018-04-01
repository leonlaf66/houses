<?php
namespace module\schooldistrict\widgets;

use WS;

class HouseList extends \yii\base\Widget
{
    public $schoolDistrict = null;

    public function run()
    {
        $towns = explode('/', $this->schoolDistrict->code);
        $cityIds = (new \yii\db\Query())
            ->select('id')
            ->from('town')
            ->where(['in', 'short_name', $towns])
            ->column();

        $listNos = (new \yii\db\Query())
            ->select('list_no')
            ->from('house_index_v2')
            ->andWhere(['in', 'city_id', $cityIds])
            ->andWhere(['=', 'prop_type', 'SF'])
            ->andWhere(['>', 'list_price', 700000])
            ->andWhere(['is_online_abled' => true])
            ->orderBy(['list_no' => SORT_DESC])
            ->limit(10)
            ->column();

        $houses = \WS::$app->houseApi->create('house/list-by-ids')
            ->setParams([
                'ids' => $listNos
            ])
            ->send()
            ->asData();

        return $this->render('house-list.phtml', ['houses'=>$houses]);
    }
}