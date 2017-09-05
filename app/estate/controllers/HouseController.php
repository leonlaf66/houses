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

        if ($type === 'purchase') { // 默认为前三种房源类型，能过cookie做状态切换
            if ($params === '') {
                if (! \WS::$app->request->cookies->getValue('def-sell-type-flag', false)) {
                    if ($tab === 'search') {
                        $q = '';
                        if (isset($_GET['q'])) $q = '?q='.$_GET['q'];
                        return $this->redirect('/house/purchase/pt-sf2mf2cc/'.$q);
                    }
                    return $this->redirect('/house/purchase/'.$tab.'/pt-sf2mf2cc/');
                }
            } elseif ($params !== 'pt-sf2mf2cc') { // 写cookie状态
                \WS::$app->response->cookies->add(new \yii\web\Cookie([
                    'name' => 'def-sell-type-flag',
                    'value' => 1,
                    'expire' => time() + 3600, // 8 小时
                    'domain' => domain()
                ]));
            }
        }

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

        WS::$app->page->setId('estate/house/'.$type);

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

        WS::$app->page->setId('estate/house/'.$type.'/view');
        WS::$app->page->bindParams(['name' => $rets->title()]);

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