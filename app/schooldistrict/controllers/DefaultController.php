<?php
namespace module\schooldistrict\controllers;

use WS;
use module\schooldistrict\models\SchoolDistrict;

class DefaultController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $items = WS::$app->cache->get('schooldistrict.list');
        if (!$items) {
            $items = SchoolDistrict::xFind()->all();
            WS::$app->cache->set('schooldistrict.list', $items);
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
        $schoolDistrict = WS::$app->cache->get('schooldistrict.detail'.$id);
        if (!$schoolDistrict) {
            $schoolDistrict = SchoolDistrict::find()->where('id=:id', ['id' => $id])->one();
            WS::$app->cache->set('schooldistrict.detail'.$id, $schoolDistrict);
        }

        WS::$app->page->bindParams(['name' => $schoolDistrict->name]);
        if ($schoolDistrict->seo) {
            WS::$app->page->metas = (Array)$schoolDistrict->seo;
        }

        return $this->render('view.phtml', [
            'model' => $schoolDistrict
        ]);
    }
}