<?php
namespace module\news\controllers;

use WS;
use yii\web\Controller;
use common\core\TaxonomyTerm;
use module\news\models\News;

class DefaultController extends Controller
{
    public function actionIndex()
    {   
        $typeId = intval(\WS::$app->request->get('type', 0));
        $newsProvider = News::search($typeId);

        //$types = News::types();
        $types = TaxonomyTerm::find()
            ->where([
                'taxonomy_id' => 3,
                'parent_id' => 0
            ])
            ->asArray()
            ->all();

        $types = \common\helper\ArrayHelper::index($types, 'id', (WS::$app->language === 'zh-CN' ? 'name_zh' : 'name'));

        $pages = new \yii\data\Pagination([
            'totalCount' =>$newsProvider->query->count(),
            'defaultPageSize'=>10,
            'pageSizeLimit'=>false
        ]);

    	return $this->render('index.phtml', [
            'typeId'=>$typeId,
            'types'=>$types,
            'pages'=>$pages,
            'newsProvider'=>$newsProvider
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view.phtml', [
            'news'=>News::findOne($id)
        ]);
    }

    public function actionPdf($file)
    {
        return $this->render('pdf-view.phtml', [
            'file'=>$file
        ]);
    }
}