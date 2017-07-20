<?php
namespace module\customer\controllers;

use WS;

class RetsFavoriteController extends \yii\web\Controller
{
    public function actionAdd()
    {
        $result = -1;

        if (! WS::$app->user->isGuest) {
            $result = \common\customer\RetsFavorite::add(WS::$app->request->get('list_no', 0), WS::$app->user->id);    
        }

        echo json_encode($result);
    }
}