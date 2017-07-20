<?php
namespace module\estate\widgets\view;

use WS;

class Around extends \yii\base\Widget 
{  
    public $rets = null;

    public function run()
    {  
        return $this->render('around.phtml', [
            'rets'=>$this->rets
        ]);
    }
}