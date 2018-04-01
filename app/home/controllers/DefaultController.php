<?php
namespace module\home\controllers;

class DefaultController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $areaId = explode('.', \WS::$app->request->getHostName())[0];
        if (!in_array(strtolower($areaId), ['ma', 'ny', 'ga', 'ca', 'il'])) {
            return $this->redirect('/area/');
        }

        return $this->render('index.phtml');
    }

    public function actionArea()
    {
        $this->layout = '@module/page/views/layouts/simple.phtml';

        return $this->render('area.phtml');
    }
}