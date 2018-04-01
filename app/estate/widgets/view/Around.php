<?php
namespace module\estate\widgets\view;

use WS;

class Around extends \yii\base\Widget 
{  
    public $data = [];

    public function run()
    {  
        return $this->render('around.phtml', [
            'data'=>$this->data,
        ]);
    }
}