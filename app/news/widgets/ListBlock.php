<?php
namespace module\news\widgets;

use module\news\models\News;;

class ListBlock extends \yii\base\Widget
{
    public $heading = '';
    public $type = ''; // infomation / hot / category
    public $theNews = null;

    public function run()
    {
        $news = News::find();
        switch ($this->type) {
            case 'infomation':
                $news->andWhere(['=', 'is_infomation', true]);
                break;
            case 'hot':
                $news->orderBy([
                    'hits' => 'DESC'
                ]);
                break;
            case 'category':
                $news->andWhere(['=', 'type_id', $this->theNews->type_id]);
                $news->andWhere(['<>', 'id', $this->theNews->id]);
                break;
        }

        $news->orderBy('id', 'DESC');
        $items = $news->limit(5)->all();

        return $this->render('list-block.phtml', [
            'heading' => $this->heading,
            'items'=>$items
        ]);
    }
}