<?php
namespace module\estate\widgets\search;

use WS;
use module\estate\helpers;

class Input extends \yii\base\Widget 
{
    public $id = 'q';
    public $requestUrl = 'estate/autocomplete/index';
    public $resultUrl = ['estate/house/index', 'type' => 'sease']; // /purchase/
    public $type = 'sease';

    public function init()
    {
        $this->requestUrl = create_url($this->requestUrl);
        $this->resultUrl = create_url($this->resultUrl);
        if ($type = WS::$app->share('rets.property')) {
            $this->type = $type;
        }

        return parent::init();
    }

    public function run()
    {
        return $this->render('input.phtml', [
            'id'=>$this->id,
            'q'=>$this->getQueryText(),
            'requestUrl'=>$this->requestUrl,
            'resultUrl'=>$this->resultUrl,
            'type' => $this->type
        ]);  
    }

    public function getQueryText()
    {
        return \WS::$app->request->get('q', '');
    }
}