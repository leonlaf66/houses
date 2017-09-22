<?php
namespace module\home\controllers;

use WS;

class DefaultController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            [
                'class' => 'yii\filters\PageCache',
                'only' => ['index', 'area'],
                'duration' => '86400',
                'variations' => [
                    WS::$app->stateId,
                    WS::$app->language,
                    WS::$app->user->isGuest
                ]
            ]
        ];
    }

    public function actionIndex()
    {
        if (! \WS::$app->stateId) {
            $this->redirect(['/home/default/area']);
        }

        return $this->render('index.phtml');
    }

    public function actionArea()
    {
        $this->layout = '@module/page/views/layouts/simple.phtml';
        return $this->render('area.phtml');
    }
}