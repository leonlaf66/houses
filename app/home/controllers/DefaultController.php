<?php
namespace module\home\controllers;

class DefaultController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $areaId = explode('.', \WS::$app->request->getHostName())[0];
        if (!in_array(strtolower($areaId), ['ma', 'ny', 'ga', 'ca', 'il'])) {
            $this->layout = '@module/page/views/layouts/simple.phtml';
            \WS::$app->page->metas = [
                'title' => tt(['Housing for sale', '美国房产/美国买房']),
                'keywords' => '海外房产,海外购房,美国房产网,北美房产网,海外买房,美国置业,海外置业,海外投资,美国投资,美国炒房,海外炒房,美国房地产,美国房产,美国购房,美国买房,北美房地产,美国房产咨询,北美房产咨询,波士顿房产咨询,波士顿买房,波士顿租房,波士顿房产,波士顿购房,波士顿房产网,波士顿房产网,波士顿置业,波士顿投资,波士顿炒房,波士顿房地产',
                'description' => '米乐居是美国房地产网络平台，本站为用户提供最新、最全的实时房源，提供国内用户一条龙房产服务。让您不再为海外置业选房、看房、买房、养房发愁。'
            ];

            return $this->render('area.phtml');
        }

        \WS::share('isHome', true);
        return $this->render('index.phtml');
    }

    public function actionArea()
    {
        return $this->redirect('/');
    }
}