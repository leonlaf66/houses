<?php
namespace module\comment\controllers;

use module\comment\models as model;

class IndexController extends \yii\web\Controller
{	
	public function actionList($path)
	{
		$commentPage = model\CommentPage::find()->where('url=:url', [':url'=>$path])->one();
		
		$comments = $commentPage ? $commentPage->comment : array();

		return $this->renderPartial('list.phtml', array(
			'comments'=>$comments
		));
	}

	public function actionSubmit($path)
	{
		$commentPage = model\CommentPage::find()->where(['url'=>$path])->one();
		if(! $commentPage) {
			$commentPage = new model\CommentPage();
			$commentPage->url = $path;
			$commentPage->hash = md5($path);
			$commentPage->save();
		}

		$comment = new model\Comment();
		$comment->attributes = $_POST;
		$comment->user_id = \WS::$app->user->id;
		$comment->page_id = $commentPage->id;
		$result = $comment->save();

		echo json_encode($result);
	}
}
