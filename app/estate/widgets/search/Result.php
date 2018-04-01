<?php
namespace module\estate\widgets\search;

use module\estate\helpers\SearchUrl;

class Result extends \yii\base\Widget
{
    public $results = [];

    public function run()
    {
        return $this->render('result.phtml', [
            'results' => $this->results
        ]);
    }

    public function createPageUrl($page)
    {
        return SearchUrl::to('page', $page);
    }
}