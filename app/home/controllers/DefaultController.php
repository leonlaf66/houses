<?php
namespace module\home\controllers;

class DefaultController extends \yii\web\Controller
{
    public function actionIndex()
    {
        if (! \WS::$app->stateId) {
            $this->layout = '@module/page/views/layouts/simple.phtml';
            return $this->render('area.phtml');
        }

        return $this->render('index.phtml');
    }
}