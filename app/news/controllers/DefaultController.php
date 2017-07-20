<?php
namespace module\news\controllers;

use yii\web\Controller;
use module\news\models\News;

class DefaultController extends Controller
{
    public function actionIndex()
    {   
        $typeId = intval(\WS::$app->request->get('type', 0));
        $newsProvider = News::search($typeId);

        $types = News::types();
        $pages = new \yii\data\Pagination([
            'totalCount' =>$newsProvider->query->count(),
            'defaultPageSize'=>10,
            'pageSizeLimit'=>false
        ]);

        $newsProvider->query->orderBy('id', 'DESC');

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