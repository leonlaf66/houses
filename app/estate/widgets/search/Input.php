<?php
namespace module\estate\widgets\search;

class Input extends \yii\base\Widget 
{
    public $id = 'q';
    public $requestUrl = '/house/search/autocomplete/';
    public $resultUrl = '/house/lease/'; // /purchase/

    public function run()
    {  
        return $this->render('input.phtml', [
            'id'=>$this->id,
            'q'=>$this->getQueryText(),
            'requestUrl'=>$this->requestUrl,
            'resultUrl'=>$this->resultUrl
        ]);  
    }

    public function getQueryText()
    {
        return \WS::$app->request->get('q', '');
    }
}