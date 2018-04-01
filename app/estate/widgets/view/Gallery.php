<?php
namespace module\estate\widgets\view;

use WS;

class Gallery extends \yii\base\Widget 
{  
    public $data = [];

    public function run()
    {  
        return $this->render('gallery.phtml', [
            'data'=>$this->data
        ]);
    }
}