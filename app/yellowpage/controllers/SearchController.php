<?php
namespace module\yellowpage\controllers;

use WS;
use module\core\models as coreModel;
use module\yellowpage\models as YPModel;

class SearchController extends \yii\web\Controller
{
	const SORT_VAR = 'sort';
    const CITY_FILTER_VAR = 'city';

    public function actionResult($type=null, $city=null, $sort=null)
    {
        $collection = YPModel\YellowPage::find();
        
        if($type) {
            $typeId = intval($type);
            $collection->innerJoinWith([
                'type'=>function($query) use($typeId) {
                    $query->where('type_id='.$typeId);
                }
            ]);
        }
        if($city) {
            $ypids = \WS::$app->db
                ->createCommand('select distinct yellowpage_id from catalog_yellow_page_cities where city_id='.intval($city))
                ->queryColumn();
            $collection->andWhere(['in', 'id', $ypids]);
            $collection->leftJoin(['city'=>'catalog_yellow_page_cities'], 'city.yellowpage_id=catalog_yellow_page.id');
            $collection->orWhere('city.city_id is null');
        }
        $collection->distinct();
        if($sort) {
            switch ($sort) {
                case 'comments':
                    $collection->orderBy('comments desc');
                    break;
                case 'rating':
                    $collection->orderBy('rating desc');
                    break;
                case 'hits':
                    $collection->orderBy('hits desc');
                    break;
                default:
                    $collection->orderBy('catalog_yellow_page.weight desc');
                    break;
            }
        }

        $pages = new \yii\data\Pagination([
            'totalCount' =>$collection->count(),
            'defaultPageSize'=>10,
            'pageSizeLimit'=>false
        ]);

        $collection = $collection->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render('result.phtml', [
            'yellowPageCollection'=>$collection,
            'pages'=>$pages,
            'city'=>$city,
            'sort'=>$sort
        ]);
    }

    public function createTypeUrl($typeId) 
    {
        return \WS::$app->urlManager->createUrl(['/yellowpage/search/', 'type'=>$typeId]);
    }

    public function createViewUrl($id) 
    {
        return \WS::$app->urlManager->createUrl(['/yellowpage/default/view', 'id'=>$id]);
    }

    public function createItemUrl($id)
    {
        return '';
    }
}