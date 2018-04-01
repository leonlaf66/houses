<?php
namespace module\estate\widgets\view;

use WS;

class Detail extends \yii\base\Widget 
{  
    public $data = [];

    public function run()
    {
        return $this->render('detail.phtml', [
            'detail'=>$this->data
        ]);
    }
}