<?php
namespace module\estate\controllers;

use WS;
use yii\web\Controller;
use \module\cms\helpers\UrlParamEncoder;

class HouseController extends Controller
{
    public function actionIndex($type = 'lease', $tab = 'search', $q='', $params='')
    {
        $req = WS::$app->request;
        WS::$app->share('rets.property', $type);
        WS::$app->share('rets.tab', $tab);

        UrlParamEncoder::setup($params, [
            'q'=>'q',
            'school-district'=>'sd',
            'subway-line'=>'sl',
            'subway-station'=>'ss',
            'property'=>'pt',
            'price'=>'pr',
            'square'=>'sq',
            'beds'=>'bd',
            'baths'=>'ba',
            'parking'=>'pa',
            'agrage'=>'ag',
            'market-days'=>'md',
            'sort'=>'st',
            'page'=>'p'
        ]);

        // 类型
        $search = \common\estate\RetsIndex::search();
        if ($type === 'lease') {
            $search->query->andFilterWhere(['=', 'prop_type', 'RN']);
        } else {
            $search->query->andFilterWhere(['<>', 'prop_type', 'RN']);
        }

        $q = $req->get('q', '');
        if ($q && strlen($q) > 0) {
            $town = \common\catalog\Town::searchKeywords($q);
            if ($town) { // 城市
                $search->query->andWhere(['town' => $town->short_name]);
            } else {
                $zipcode = \common\catalog\Zipcode::searchKeywords($q);
                if ($zipcode) { // zip
                    $search->query->andWhere(['town' => $zipcode->city_short_name]);
                } else { // 普通搜索
                    $qWhere = "to_tsvector('english', location) @@ plainto_tsquery('english', '{$q}')";
                    $search->query->andWhere($qWhere);
                }
            }

            if (is_numeric($q)) { // mls id
                $search->query->orWhere(['id' => $q]);
            }
        }

        return $this->render('index.phtml', [
            'tab'=>$tab,
            'type'=>$type,
            'search'=>$search
        ]);
    }

    public function actionView($type = 'lease', $id = null)
    {   
        $rets = \common\estate\Rets::findOne($id);
        
        if(is_null($rets )) {
            throw new \yii\web\HttpException(404, "Page not found");
        }

        return $this->render("view.phtml", [
            'type'=>$type,
            'rets'=>$rets
        ]);
    }

    public function actionTest($id) {
        $rets = \common\estate\Rets::findOne($id);
        dd($rets->render()->detail());
    }
}