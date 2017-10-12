<?php
namespace module\schooldistrict\controllers;

use WS;
use models\SchoolDistrict;

class DefaultController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $items = SchoolDistrict::xFind()->all();

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
        $schoolDistrict = SchoolDistrict::find()->where('id=:id', ['id' => $id])->one();

        WS::$app->page->bindParams(['name' => $schoolDistrict->name]);

        return $this->render('view.phtml', [
            'model' => $schoolDistrict
        ]);
    }
}