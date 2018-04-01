<?php
namespace module\estate\widgets\view;

use WS;

class Roi extends \yii\base\Widget 
{  
    public $data = null;

    public function run()
    {
        return $this->render('roi.phtml', [
            'data'=>$this->data
        ]);
    }
}