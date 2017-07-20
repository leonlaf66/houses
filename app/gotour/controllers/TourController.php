<?php
namespace module\gotour\controllers;

use WS;
use yii\web\Controller;

class TourController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionSubmit()
    {
        $req = WS::$app->request;

        $result = false;
        if($req->isPost && ! WS::$app->user->isGuest) {
            $tour = new \common\rets\gotour\Tour();
            $tour->user_id = WS::$app->user->id;
            $tour->list_no = $req->post('listNo');
            $tour->date_start = $req->post('day').' '.$req->post('timeRange')[0] . ':00';
            $tour->date_end = $req->post('day').' '.$req->post('timeRange')[1] . ':00';
            $result = $tour->save();
        }

        echo json_encode($result);
        WS::$app->end();
    }
}