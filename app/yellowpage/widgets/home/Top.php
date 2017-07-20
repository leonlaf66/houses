<?php
namespace module\yellowpage\widgets\home;

use module\yellowpage\models\YellowPage;

class Top extends \yii\base\Widget 
{  
    public function run()
    {  
        $groups = \WS::getStaticData('home.yellowpage.top');

        $this->buildYellowPageToResults($groups);

        return $this->render('top.phtml', ['groups'=>$groups]);  
    }

    public function buildYellowPageToResults(& $groups) 
    {
        $ids = [];
        foreach($groups as $group) {
            $items = $group['ids'];
            $ids = array_merge($ids, $items);
        }
        $ids = array_unique($ids);

        $allYellowpages = YellowPage::find()->where(['in', 'id', $ids])->all();
        $allYellowpages = \common\helper\ArrayHelper::entityMap($allYellowpages, 'id');

        foreach($groups as $gIdx=>$group) {
            $items = [];
            foreach($group['ids'] as $id) {
                if(isset($allYellowpages[$id])) {
                    $items[] = $allYellowpages[$id];
                }
            }
            $groups[$gIdx]['items'] = $items;
        }
    }
}