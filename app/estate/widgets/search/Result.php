<?php
namespace module\estate\widgets\search;

use yii\data\Pagination;
use module\estate\helpers\SearchUrl;

class Result extends \yii\base\Widget
{
    public $search = null;

    public function run()
    {  
        $search = $this->search;

        // $search->pagination->pageSize = 10;

        return $this->render('result.phtml', [
            'search'=>$search
        ]);  
    }

    public function createPageUrl($page)
    {
        return SearchUrl::to('page', $page);
    }
}