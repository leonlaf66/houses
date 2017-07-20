<?php
namespace module\estate\widgets\view;

use WS;

class Detail extends \yii\base\Widget 
{  
    public $rets = null;

    public function run()
    {  
        $detail = $this->rets->render()->detail();

        return $this->render('detail.phtml', [
            'detail'=>$detail
        ]);
    }
}