<?php
namespace module\yellowpage\widgets;

class Top extends \yii\base\Widget
{
    public function init()
    {
    	parent::init();
    }

    public function getItems()
    {
        return \models\YellowPage::find()
            ->orderBy('weight DESC')
            ->where('is_top=:istop', [':istop'=>1])
            ->all();
    }

    public function createTypeUrl($id) 
    {
        return \WS::$app->urlManager->createUrl(['/yellowpage/search/', 'type_id'=>$id]);
    }

    public function createItemUrl($id) 
    {
        return \WS::$app->urlManager->createUrl(['/yellowpage/default/view/', 'id'=>$id]);
    }

    public function run()
    {
    	return $this->render('top10.phtml');
    }
}