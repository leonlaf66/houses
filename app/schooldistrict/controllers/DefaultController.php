<?php
namespace module\schooldistrict\controllers;

use WS;
use common\catalog\SchoolDistrict;

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

    public function racials($items)
    {
        if (! is_array($items)) {
            $items = [];
        }

        $colors = ['#fac68d', '#aee9be', '#a3c9fb', '#99bd2a', '#f66c6c'];
        $idx = 0;
        return array_map(function ($item) use (& $idx, $colors) {
            $item->height = $idx === 0 ? '24px' : '20px';
            $item->bgColor = $colors[$idx] ?? '#f66c6c';
            $idx ++;
            return $item;
        }, $items);
    }
}