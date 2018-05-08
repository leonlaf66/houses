<?php
namespace module\estate\controllers;

use WS;
use module\core\Controller;
use module\estate\helpers;

class SearchCompleteController extends Controller
{
  public function actionIndex($type = 'lease')
  {
    $results = helpers\SearchAutocomplete::map($type === 'lease');
    
    return $this->ajaxJson($results);
  }
}