<?php
namespace module\schooldistrict\controllers;

use WS;
use module\schooldistrict\models\SchoolDistrict;

class DefaultController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $items = WS::$app->fetchCache('schooldistrict.list');
        if (!$items) {
            $items = SchoolDistrict::xFind()->all();
            WS::$app->saveCache('schooldistrict.list', $items);
        }

        WS::share('schooldistrict.items', $items);
        
        $total = 0;
        foreach($items as $item) {
            $total += $item->getSummary('total');
        }

    	return $this->render('index.phtml', [
            'summary' => [
                'count' => count($items),
                'total' => $total
            ]
        ]);
    }

    public function actionView($id)
    {
        $schoolDistrict = WS::$app->fetchCache('schooldistrict.detail'.$id);
        if (!$schoolDistrict) {
            $schoolDistrict = SchoolDistrict::find()->where('id=:id', ['id' => $id])->one();
            WS::$app->saveCache('schooldistrict.detail'.$id, $schoolDistrict);
        }

        WS::$app->page->bindParams(['name' => $schoolDistrict->name]);

        return $this->render('view.phtml', [
            'model' => $schoolDistrict
        ]);
    }
}