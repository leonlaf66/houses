<?php
namespace module\estate\widgets\view;

use WS;

class Roi extends \yii\base\Widget 
{  
    public $rets = null;

    public function run()
    {  
        return $this->render('roi.phtml', [
            'rets'=>$this->rets
        ]);
    }
}