<?php
namespace module\estate\widgets\view;

use WS;

class Recommends extends \yii\base\Widget 
{  
    public $data = null;

    public function run()
    {  
        return $this->render('recommends.phtml', [
            'data'=>$this->data,
            'nearbyHouses'=>$this->data['recommends']
        ]);
    }
}