<?php
namespace module\yellowpage\controllers;

use module\yellowpage\models\YellowPage;

class DefaultController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        return $this->render('index.phtml');
    }

    public function actionView($id)
    {

    	$yelloePage = YellowPage::findOne($id);

        $yelloePage->hits = intval($yelloePage->hits) + 1;
        $yelloePage->save();
        
    	return $this->render('view.phtml', ['model'=>$yelloePage]);
    }

    public function actionOncomment()
    {
        $req = \WS::$app->request;
        if($req->isPost) {
            $id = intval($req->get('id', 0));

            $yellowPage = YellowPage::findOne($id);
            $yellowPage->rating = intval($req->get('rating', 0));
            $yellowPage->comments = intval($req->get('total', 0));
            $yellowPage->save();
        }
    }
}